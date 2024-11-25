<script lang="ts">
    import { inertia, page, useForm } from '@inertiajs/svelte';
    import InputLabel from '@/Components/InputLabel.svelte';
    import PrimaryButton from '@/Components/PrimaryButton.svelte';
    import { fade } from 'svelte/transition';
    import { cubicInOut } from 'svelte/easing';
    import Title from '@/Components/Title.svelte';
    import Subtitle from '@/Components/Subtitle.svelte';

    const user = $page.props.auth.user;
    const form = useForm({
        theme: user.theme,
    });

    function submit(e: SubmitEvent) {
        e.preventDefault();
        $form.patch(route('profile.updateTheme'));
    }
</script>

<section>
    <header>
        <Title>Theme settings</Title>

        <Subtitle>Update the website's theme settings.</Subtitle>
    </header>

    <form onsubmit={submit} class="mt-6 space-y-6">
        <div>
            <InputLabel for="theme" value="Theme" />

            <select
                name="theme"
                id="theme"
                bind:value={$form.theme}
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
            >
                <option value="light">Light</option>
                <option value="dark">Dark</option>
            </select>
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton disabled={$form.processing}>Save</PrimaryButton>

            {#if $form.recentlySuccessful}
                <div transition:fade={{ easing: cubicInOut }}>
                    <p
                        class="text-sm text-gray-600 transition ease-in-out dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </div>
            {/if}
        </div>
    </form>
</section>
