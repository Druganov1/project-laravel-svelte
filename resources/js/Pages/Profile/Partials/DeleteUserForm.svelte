<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import DangerButton from '@/Components/DangerButton.svelte';
    import InputError from '@/Components/InputError.svelte';
    import InputLabel from '@/Components/InputLabel.svelte';
    import Modal from '@/Components/Modal.svelte';
    import SecondaryButton from '@/Components/SecondaryButton.svelte';
    import TextInput from '@/Components/TextInput.svelte';
    import Title from '@/Components/Title.svelte';
    import Subtitle from '@/Components/Subtitle.svelte';

    let confirmingUserDeletion = $state(false);
    let passwordInput: TextInput;

    const form = useForm({
        password: '',
    });

    function closeModal() {
        $form.clearErrors();
        $form.reset();
        confirmingUserDeletion = false;
    }

    function confirmUserDeletion() {
        confirmingUserDeletion = true;
        setTimeout(() => passwordInput?.focus(), 250);
    }

    function deleteUser() {
        $form.delete(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput?.focus(),
            onFinish: () => $form.reset(),
        });
    }
</script>

<section class="space-y-6">
    <header>
        <Title>Delete Account</Title>

        <Subtitle>
            Once your account is deleted, all of its resources and data will be
            permanently deleted. Before deleting your account, please download
            any data or information that you wish to retain.
        </Subtitle>
    </header>

    <DangerButton onclick={confirmUserDeletion}>Delete Account</DangerButton>

    <Modal show={confirmingUserDeletion} onclose={closeModal}>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                Are you sure you want to delete your account?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Please enter your password to confirm
                you would like to permanently delete your account.
            </p>

            <div class="mt-6">
                <InputLabel for="password" value="Password" class="sr-only" />

                <TextInput
                    id="password"
                    bind:this={passwordInput}
                    bind:value={$form.password}
                    type="password"
                    class="block w-full mt-1"
                    placeholder="Password"
                    onkeyup={(e: KeyboardEvent) =>
                        e.key === 'Enter' && deleteUser()}
                />

                <InputError message={$form.errors.password} class="mt-2" />
            </div>

            <div class="flex justify-end mt-6">
                <SecondaryButton onclick={closeModal}>Cancel</SecondaryButton>

                <DangerButton
                    class="ms-3 {$form.processing && 'opacity-25'}"
                    disabled={$form.processing}
                    onclick={deleteUser}
                >
                    Delete Account
                </DangerButton>
            </div>
        </div>
    </Modal>
</section>
