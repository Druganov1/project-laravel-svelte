<script lang="ts">
    import type { Snippet } from 'svelte';
    import { inertia, page } from '@inertiajs/svelte';

    import ApplicationLogo from '@/Components/ApplicationLogo.svelte';
    import Dropdown from '@/Components/Dropdown.svelte';
    import DropdownLink from '@/Components/DropdownLink.svelte';
    import NavLink from '@/Components/NavLink.svelte';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.svelte';

    let { children, header }: { children: Snippet; header: Snippet } = $props();

    let showingNavigationDropdown = $state(false);
</script>

<div class={$page.props.auth.user.theme}>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-700">
        <nav
            class="bg-white border-b border-gray-100 dark:border-gray-700 dark:bg-gray-800"
        >
            <!-- Primary Navigation Menu -->
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex items-center shrink-0">
                            <a use:inertia href={route('dashboard')}>
                                <ApplicationLogo
                                    class="block w-auto text-gray-800 fill-current h-9"
                                />
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div
                            class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"
                        >
                            <NavLink
                                href={route('dashboard')}
                                active={route().current('dashboard')}
                            >
                                Dashboard
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <!-- Settings Dropdown -->
                        <div class="relative ms-3">
                            <Dropdown
                                align="right"
                                width="48"
                                contentClasses="dark:bg-gray-700"
                            >
                                {#snippet trigger()}
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:bg-gray-700 dark:text-white hover:text-gray-700 focus:outline-none"
                                        >
                                            {$page.props.auth.user.name}
                                            <svg
                                                class="-me-0.5 ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                {/snippet}

                                {#snippet content()}
                                    <DropdownLink href={route('profile.edit')}>
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink
                                        href={route('logout')}
                                        method="post"
                                        as="button">Log Out</DropdownLink
                                    >
                                {/snippet}
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="flex items-center -me-2 sm:hidden">
                        <!-- svelte-ignore a11y_consider_explicit_label -->
                        <button
                            onclick={() =>
                                (showingNavigationDropdown =
                                    !showingNavigationDropdown)}
                            class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                        >
                            <svg
                                class="w-6 h-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    class={showingNavigationDropdown
                                        ? 'hidden'
                                        : 'inline-flex'}
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    class={showingNavigationDropdown
                                        ? 'inline-flex'
                                        : 'hidden'}
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                class={`${showingNavigationDropdown ? 'block' : 'hidden'} sm:hidden`}
            >
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink
                        href={route('dashboard')}
                        active={route().current('dashboard')}
                    >
                        Dashboard
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="text-base font-medium text-gray-800">
                            {$page.props.auth.user.name}
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            {$page.props.auth.user.email}
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink
                            href={route('profile.edit')}
                            active={route().current('profile.edit')}
                            >Profile</ResponsiveNavLink
                        >
                        <ResponsiveNavLink
                            href={route('logout')}
                            method="post"
                            type="button">Log Out</ResponsiveNavLink
                        >
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        {#if header}
            <header class="bg-white shadow dark:bg-gray-800">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {@render header()}
                </div>
            </header>
        {/if}

        <!-- Page Content -->
        <main>
            {@render children()}
        </main>
    </div>
</div>
