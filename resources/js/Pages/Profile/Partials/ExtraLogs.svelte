<script lang="ts">
    import { inertia, page, useForm } from '@inertiajs/svelte';
    import InputLabel from '@/Components/InputLabel.svelte';
    import PrimaryButton from '@/Components/PrimaryButton.svelte';
    import { fade } from 'svelte/transition';
    import { cubicInOut } from 'svelte/easing';
    import Title from '@/Components/Title.svelte';
    import Subtitle from '@/Components/Subtitle.svelte';
    import TextInput from '@/Components/TextInput.svelte';

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
        <Title>Account logs</Title>

        <Subtitle>Extra info regarding your profile.</Subtitle>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <InputLabel for="ip" value="Last logged in IP" />

            <TextInput
                id="ip"
                disabled
                type="text"
                class={`block w-full mt-1 ${user.provider ? 'disabled bg-slate-200' : ''}`}
                value={user.last_logged_in_ip}
            />

        </div>

        <div>
            <InputLabel for="pass" value="Last changed password date" />

            <TextInput
                id="pass"
                disabled
                type="text"
                class={`block w-full mt-1 ${user.provider ? 'disabled bg-slate-200' : ''}`}
                value={new Date(user.last_changed_password).toLocaleDateString('nl-NL', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}
            />
        </div>




    </div>
</section>
