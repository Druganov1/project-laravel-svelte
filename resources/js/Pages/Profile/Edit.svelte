<script lang="ts">
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte';
    import DeleteUserForm from './Partials/DeleteUserForm.svelte';
    import UpdatePasswordForm from './Partials/UpdatePasswordForm.svelte';
    import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.svelte';
    import UpdateTheme from './Partials/UpdateTheme.svelte';
    import { page } from '@inertiajs/svelte';
    import ExtraLogs from './Partials/ExtraLogs.svelte';


    let {
        mustVerifyEmail,
        status,
    }: {
        mustVerifyEmail?: boolean;
        status?: string;
    } = $props();

    const user = $page.props.auth.user;

</script>

<svelte:head>
    <title>Profile</title>
</svelte:head>

<AuthenticatedLayout>
    {#snippet header()}
        <h2
            class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100"
        >
            Profile
        </h2>
    {/snippet}

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div
                class="p-4 bg-white shadow dark:bg-gray-800 sm:rounded-lg sm:p-8"
            >
                <UpdateTheme class="max-w-xl" />
            </div>

            <div
                class="p-4 bg-white shadow dark:bg-gray-800 sm:rounded-lg sm:p-8"
            >
                <UpdateProfileInformationForm
                    {mustVerifyEmail}
                    {status}
                    class="max-w-xl"
                />
            </div>

            {#if user.provider === null || user.provider === '' }

            <div
                class="p-4 bg-white shadow dark:bg-gray-800 sm:rounded-lg sm:p-8"
            >
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            {/if}
            <div
                class="p-4 bg-white shadow dark:bg-gray-800 sm:rounded-lg sm:p-8"
            >
                <DeleteUserForm class="max-w-xl" />
            </div>


            <div
            class="p-4 bg-white shadow dark:bg-gray-800 sm:rounded-lg sm:p-8"
        >
            <ExtraLogs class="max-w-xl" />
        </div>
        </div>
    </div>
</AuthenticatedLayout>
