<template>
    <JetBarLayout title="Dashboard">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-8/12 px-4">
                <div
                    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-slate-100 border-0">
                    <div class="rounded-t bg-white mb-0 px-6 py-6">
                        <div class="text-center flex justify-between">
                            <h6 class="text-slate-700 text-xl font-bold">My account</h6>
                            <button
                                class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                type="button">
                                Settings
                            </button>
                        </div>
                    </div>
                    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <form>
                            <h6 class="text-slate-400 text-sm mt-3 mb-6 font-bold uppercase">
                                User Information
                            </h6>
                            <div class="flex flex-wrap">
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            Username
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="lucky.jesse" />
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            Email address
                                        </label>
                                        <input type="email"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="jesse@example.com" />
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            First Name
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Lucky" />
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            Last Name
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Jesse" />
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-6 border-b-1 border-slate-300" />

                            <h6 class="text-slate-400 text-sm mt-3 mb-6 font-bold uppercase">
                                Contact Information
                            </h6>
                            <div class="flex flex-wrap">
                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            Address
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" />
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            City
                                        </label>
                                        <input type="email"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="New York" />
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            Country
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="United States" />
                                    </div>
                                </div>
                                <div class="w-full lg:w-4/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            Postal Code
                                        </label>
                                        <input type="text"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            value="Postal Code" />
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-6 border-b-1 border-slate-300" />

                            <h6 class="text-slate-400 text-sm mt-3 mb-6 font-bold uppercase">
                                About Me
                            </h6>
                            <div class="flex flex-wrap">
                                <div class="w-full lg:w-12/12 px-4">
                                    <div class="relative w-full mb-3">
                                        <label class="block uppercase text-slate-600 text-xs font-bold mb-2"
                                            htmlFor="grid-password">
                                            About me
                                        </label>
                                        <textarea type="text"
                                            class="border-0 px-3 py-3 placeholder-slate-300 text-slate-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                            rows="4">
                    A beautiful UI Kit and Admin for VueJS & Tailwind CSS. It is Free
                    and Open Source.
                  </textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-4/12 px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg mt-16">
                    <div class="px-6">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full px-4 flex justify-center">
                                <div class="relative">
                                    <img alt="..." :src="team2"
                                        class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px" />
                                </div>
                            </div>
                            <div class="w-full px-4 text-center mt-20">
                                <div class="flex justify-center py-4 lg:pt-4 pt-8">
                                    <div class="mr-4 p-3 text-center">
                                        <span class="text-xl font-bold block uppercase tracking-wide text-slate-600">
                                            22
                                        </span>
                                        <span class="text-sm text-slate-400">Friends</span>
                                    </div>
                                    <div class="mr-4 p-3 text-center">
                                        <span class="text-xl font-bold block uppercase tracking-wide text-slate-600">
                                            10
                                        </span>
                                        <span class="text-sm text-slate-400">Photos</span>
                                    </div>
                                    <div class="lg:mr-4 p-3 text-center">
                                        <span class="text-xl font-bold block uppercase tracking-wide text-slate-600">
                                            89
                                        </span>
                                        <span class="text-sm text-slate-400">Comments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-12">
                            <h3 class="text-xl font-semibold leading-normal mb-2 text-slate-700 mb-2">
                                Jenna Stones
                            </h3>
                            <div class="text-sm leading-normal mt-0 mb-2 text-slate-400 font-bold uppercase">
                                <i class="fas fa-map-marker-alt mr-2 text-lg text-slate-400"></i>
                                Los Angeles, California
                            </div>
                            <div class="mb-2 text-slate-600 mt-10">
                                <i class="fas fa-briefcase mr-2 text-lg text-slate-400"></i>
                                Solution Manager - Creative Tim Officer
                            </div>
                            <div class="mb-2 text-slate-600">
                                <i class="fas fa-university mr-2 text-lg text-slate-400"></i>
                                University of Computer Science
                            </div>
                        </div>
                        <div class="mt-10 py-10 border-t border-slate-200 text-center">
                            <div class="flex flex-wrap justify-center">
                                <div class="w-full lg:w-9/12 px-4">
                                    <p class="mb-4 text-lg leading-relaxed text-slate-700">
                                        An artist of considerable range, Jenna the name taken by
                                        Melbourne-raised, Brooklyn-based Nick Murphy writes, performs and
                                        records all of his own music, giving it a warm, intimate feel with
                                        a solid groove structure. An artist of considerable range.
                                    </p>
                                    <a href="javascript:void(0);" class="font-normal text-emerald-500">
                                        Show more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </JetBarLayout>
</template>

<script setup>
import JetBarLayout from '@res/vue/Layouts/JetBarLayout.vue'
import CardSocialTraffic from '@res/vue/Components/Notus/Cards/CardSocialTraffic.vue';
</script>
