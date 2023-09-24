<template>
    <pf-dropdown hide-arrow class="user-menu">
    <div slot="button">
        <pf-image
            :src="authentication && authentication.profile && authentication.profile.picture"
            fallbackSrc="assets/img/default-profile.png"
            class="user-image-small"
            width="25"
            height="25"
            alt="User Image"
            rounded
        ></pf-image>
    </div>
    <div slot="menu">
        <li class="user-header bg-primary">
            <pf-image
                :src="authentication && authentication.profile && authentication.profile.picture"
                fallbackSrc="assets/img/default-profile.png"
                class="user-image-big"
                alt="User Image"
                width="90"
                height="90"
                rounded
            ></pf-image>

            <p>
                <span
                    >{{authentication && authentication.profile &&
                    authentication.profile.email}}</span
                >
                <small>
                    <span>{{ $t("labels.memberSince") }}&nbsp;</span>
                    <span>{{readableCreatedAtDate}}</span>
                </small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col-4 text-center">
                    <a href="#">{{ $t("labels.followers") }}</a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">{{ $t("labels.sales") }}</a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">{{ $t("labels.friends") }}</a>
                </div>
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <router-link
                to="/profile"
                class="btn btn-default btn-flat"
                @click="isDropdownOpened = false;"
            >
                {{ $t("labels.profile") }}
            </router-link>
            <button
                @click="logout"
                class="btn btn-default btn-flat float-right"
            >
                {{ $t("labels.signOut") }}
            </button>
        </li>
    </div>
</pf-dropdown>

</template>

<script setup lang="ts">
import {Component, Vue} from 'vue-facing-decorator';
import {DateTime} from 'luxon';
import {PfDropdown, PfImage} from '@profabric/vue-components';
import {GoogleProvider} from '@/utils/oidc-providers';

declare const FB: any;

@Component({
    name: 'user-dropdown',
    components: {
        'pf-dropdown': PfDropdown,
        'pf-image': PfImage
    }
})
export default class User extends Vue {
    get authentication(): any {
        return this.$store.getters['auth/authentication'];
    }

    async logout() {
        // setDropdownOpen(false);
        try {
            if (this.authentication.profile.first_name) {
                await GoogleProvider.signoutPopup();
                this.$store.dispatch('auth/setAuthentication', undefined);
            } else if (this.authentication.userID) {
                FB.logout(() => {
                    this.$store.dispatch('auth/setAuthentication', undefined);
                    this.$router.replace('/login');
                });
            }
            localStorage.removeItem('authentication');
            this.$router.replace('/login');
        } catch (error) {
            localStorage.removeItem('authentication');
            this.$router.replace('/login');
        }
    }

    get readableCreatedAtDate() {
        if (this.authentication && this.authentication.createdAt) {
            return DateTime.fromISO(this.authentication.createdAt).toFormat(
                'dd LLLL yyyy'
            );
        }
        return '';
    }
}
</script>