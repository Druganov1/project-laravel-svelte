<script lang="ts">
    import Checkbox from '@/Components/Checkbox.svelte';
    import GuestLayout from '@/Layouts/GuestLayout.svelte';
    import InputError from '@/Components/InputError.svelte';
    import InputLabel from '@/Components/InputLabel.svelte';
    import PrimaryButton from '@/Components/PrimaryButton.svelte';
    import TextInput from '@/Components/TextInput.svelte';
    import { inertia, useForm } from '@inertiajs/svelte';
    import SocialLoginButton from '@/Components/SocialLoginButton.svelte';

    let {
        canResetPassword,
        status,
    }: {
        canResetPassword?: boolean;
        status?: string;
    } = $props();

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e: SubmitEvent) => {
        e.preventDefault();

        $form.post(route('login'), {
            onFinish: () => $form.reset('password'),
        });
    };
</script>

<svelte:head>
    <title>Log in</title>
</svelte:head>

<GuestLayout>
    {#if status}
        <div class="mb-4 text-sm font-medium text-green-600">
            {status}
        </div>
    {/if}

    <form onsubmit={submit}>
        <div>
            <InputLabel for="email" value="Email" />

            <TextInput
                id="email"
                type="email"
                class="block w-full mt-1"
                bind:value={$form.email}
                required
                autofocus
                autocomplete="username"
            />

            <InputError class="mt-2" message={$form.errors.email} />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Password" />

            <TextInput
                id="password"
                type="password"
                class="block w-full mt-1"
                bind:value={$form.password}
                required
                autocomplete="current-password"
            />

            <InputError class="mt-2" message={$form.errors.password} />
        </div>

        <div class="block mt-4">
            <label for="remember-me" class="flex items-center">
                <Checkbox
                    id="remember-me"
                    name="remember"
                    bind:checked={$form.remember}
                />
                <span class="text-sm text-gray-600 ms-2">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            {#if canResetPassword}
                <a
                    use:inertia
                    href={route('password.request')}
                    class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </a>
            {/if}

            <PrimaryButton
                class="ms-4 {$form.processing && 'opacity-25'}"
                disabled={$form.processing}>Log in</PrimaryButton
            >

        </div>
        <div class="flex flex-col gap-1 mt-4">
            <SocialLoginButton provider="github"></SocialLoginButton>
            <SocialLoginButton provider="discord"></SocialLoginButton>



        </div>
    </form>
</GuestLayout>
