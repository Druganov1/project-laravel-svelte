<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import InputError from '@/Components/InputError.svelte';
    import InputLabel from '@/Components/InputLabel.svelte';
    import PrimaryButton from '@/Components/PrimaryButton.svelte';
    import TextInput from '@/Components/TextInput.svelte';
    import { fade } from 'svelte/transition';
    import { cubicInOut } from 'svelte/easing';
    import Title from '@/Components/Title.svelte';
    import Subtitle from '@/Components/Subtitle.svelte';

    let passwordInput: TextInput;
    let currentPasswordInput: TextInput;

    const form = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    function updatePassword(e: SubmitEvent) {
        e.preventDefault();
        $form.put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => $form.reset(),
            onError: () => {
                if ($form.errors.password) {
                    $form.reset('password', 'password_confirmation');
                    passwordInput?.focus();
                }
                if ($form.errors.current_password) {
                    $form.reset('current_password');
                    currentPasswordInput?.focus();
                }
            },
        });
    }
</script>

<section>
    <header>
        <Title>Update Password</Title>

        <Subtitle
            >Ensure your account is using a long, random password to stay
            secure.</Subtitle
        >
    </header>

    <form onsubmit={updatePassword} class="mt-6 space-y-6">
        <div>
            <InputLabel for="current_password" value="Current Password" />

            <TextInput
                id="current_password"
                bind:this={currentPasswordInput}
                bind:value={$form.current_password}
                type="password"
                class="block w-full mt-1"
                autocomplete="current-password"
            />

            <InputError message={$form.errors.current_password} class="mt-2" />
        </div>

        <div>
            <InputLabel for="password" value="New Password" />

            <TextInput
                id="password"
                bind:this={passwordInput}
                bind:value={$form.password}
                type="password"
                class="block w-full mt-1"
                autocomplete="new-password"
            />

            <InputError message={$form.errors.password} class="mt-2" />
        </div>

        <div>
            <InputLabel for="password_confirmation" value="Confirm Password" />

            <TextInput
                id="password_confirmation"
                bind:value={$form.password_confirmation}
                type="password"
                class="block w-full mt-1"
                autocomplete="new-password"
            />

            <InputError
                message={$form.errors.password_confirmation}
                class="mt-2"
            />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton disabled={$form.processing}>Save</PrimaryButton>

            {#if $form.recentlySuccessful}
                <div transition:fade={{ easing: cubicInOut }}>
                    <p class="text-sm text-gray-600 transition ease-in-out">
                        Saved.
                    </p>
                </div>
            {/if}
        </div>
    </form>
</section>
