<template>
    <div>
        <a class="hover:text-slate-500 text-slate-700 px-3 py-2 flex items-center text-xs uppercase font-bold" href="#pablo"
            ref="btnDropdownRef" v-on:click="toggleDropdown($event)">
            Demo Pages
        </a>
        <div ref="popoverDropdownRef"
            class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" v-bind:class="{
                hidden: !dropdownPopoverShow,
                block: dropdownPopoverShow,
            }">
            <span class="text-sm pt-2 pb-0 px-4 font-bold block w-full whitespace-nowrap bg-transparent text-slate-400">
                Admin Layout
            </span>
            <Link href="/admin/dashboard"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Dashboard
            </Link>
            <Link href="/admin/settings"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Settings
            </Link>
            <Link href="/admin/tables"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Tables
            </Link>
            <Link href="/admin/maps"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Maps
            </Link>
            <div class="h-0 mx-4 my-2 border border-solid border-slate-100" />
            <span class="text-sm pt-2 pb-0 px-4 font-bold block w-full whitespace-nowrap bg-transparent text-slate-400">
                Auth Layout
            </span>
            <Link href="/auth/login"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Login
            </Link>
            <Link href="/auth/register"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Register
            </Link>
            <div class="h-0 mx-4 my-2 border border-solid border-slate-100" />
            <span class="text-sm pt-2 pb-0 px-4 font-bold block w-full whitespace-nowrap bg-transparent text-slate-400">
                No Layout
            </span>
            <Link href="/landing"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Landing
            </Link>
            <Link href="/profile"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700">
            Profile
            </Link>
        </div>
    </div>
</template>
<script>
import { createPopper } from "@popperjs/core";
import { Link } from '@inertiajs/vue3';

export default {
    data() {
        return {
            dropdownPopoverShow: false,
        };
    },
    components: { Link },
    methods: {
        toggleDropdown: function (event) {
            event.preventDefault();
            if (this.dropdownPopoverShow) {
                this.dropdownPopoverShow = false;
            } else {
                this.dropdownPopoverShow = true;
                createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
                    placement: "bottom-start",
                });
            }
        },
    },
};
</script>
