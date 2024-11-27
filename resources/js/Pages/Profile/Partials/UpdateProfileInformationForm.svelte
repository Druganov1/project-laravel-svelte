<script lang="ts">
    import { inertia, page, useForm } from '@inertiajs/svelte';
    import InputError from '@/Components/InputError.svelte';
    import InputLabel from '@/Components/InputLabel.svelte';
    import PrimaryButton from '@/Components/PrimaryButton.svelte';
    import TextInput from '@/Components/TextInput.svelte';
    import { fade } from 'svelte/transition';
    import { cubicInOut } from 'svelte/easing';
    import Title from '@/Components/Title.svelte';
    import Subtitle from '@/Components/Subtitle.svelte';
    import Dropdown from '@/Components/Dropdown.svelte';
    import DropdownLink from '@/Components/DropdownLink.svelte';
    import Modal from '@/Components/Modal.svelte';
    import DangerButton from '@/Components/DangerButton.svelte';
    import SecondaryButton from '@/Components/SecondaryButton.svelte';

    let confirmingProfilePicDeletion  = $state(false);
    let selectedFile: File | null = null;

    let {
        mustVerifyEmail,
        status,
    }: {
        mustVerifyEmail?: boolean;
        status?: string;
    } = $props();

    const user = $page.props.auth.user;
    const form = useForm({
        name: user.name,
        email: user.email,
    });

    function submit(e: SubmitEvent) {
        e.preventDefault();
        $form.patch(route('profile.update'));
    }

    function closeModal() {

        confirmingProfilePicDeletion = false;
    }

    function confirmProfilePicDeletion() {
        confirmingProfilePicDeletion = true;
    }

    function deleteProfilePic() {
        $form.delete(route('profile.deletepic'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }



        function uploadPhotoClick() {
        const input = document.getElementById('file-upload') as HTMLInputElement;
        if (input) {
            console.log("Uploading photo");
            input.click();
        }
    }


    import axios from 'axios';

function handleFileChange(event) {
    const input = event.target;
    if (input && input.files?.length > 0) {
        const file = input.files[0]; // Get the selected file
        console.log("File selected:", file);

        // Create a FormData object
        const formData = new FormData();
        formData.append('profile_pic', file);

        // Send the file with Axios
        axios.post(route('profile.uploadpic'), formData)
            .then((response) => {
                console.log('Profile picture uploaded successfully');
            })
            .catch((error) => {
                console.error('Failed to upload profile picture', error.response?.data || error);
            });
    } else {
        console.log("No file selected");
    }
}





    function removePhoto() {
        console.log('Photo removed');

        axios.delete(route('profile.deletepic'))
            .then((response) => {
                console.log('Profile picture deleted successfully');
            })
            .catch((error) => {
                console.error('Failed to delete profile picture', error.response?.data || error);
            });
    }


</script>

<section>
    <header>
        <Title>Profile Information</Title>

        <Subtitle
            >Update your account's profile information and email address.</Subtitle
        >
    </header>
    <div class="flex flex-col mt-4 space-y-2">
        <div class="w-32 h-32">
            <img
                id="profile-picture"
                src={user.profile_pic_b64 ? `data:image/png;base64,${user.profile_pic_b64}` : '/assets/img/defaultuser.webp'}
                alt="Profile Picture"
                title="Profile Picture"
                class="object-cover w-full h-full transition-opacity duration-300 ease-in-out border border-gray-600 rounded-full hover:opacity-70"
            />
        </div>


        <Dropdown
        align="left"
        width="48"
        contentClasses="dark:bg-gray-700"
    >
        {#snippet trigger()}
            <span class="inline-flex rounded-md">
                <button
                    type="button"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:bg-gray-700 dark:text-white hover:text-gray-700 focus:outline-none"
                >
                    Edit
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



                <div
                class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out cursor-pointer text-start dark:text-white dark:hover:bg-gray-500 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
                onclick={uploadPhotoClick}
                  >
                Upload a photo
            </div>



            <div
            class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out cursor-pointer text-start dark:text-white dark:hover:bg-gray-500 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
            onclick={confirmProfilePicDeletion}
            >
                Remove photo
      </div>
        {/snippet}
    </Dropdown>


    </div>

    <input
    id="file-upload"
    type="file"
    style="display:none"
    accept="image/*"
    onchange={handleFileChange}
/>

    <Modal show={confirmingProfilePicDeletion } onclose={closeModal}>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                Are you sure you want to reset your profile picture?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            This action cannot be undone.
            </p>


            <div class="flex justify-end mt-6">
                <SecondaryButton onclick={closeModal}>Cancel</SecondaryButton>

                <DangerButton
                    class="ms-3"
                    onclick={deleteProfilePic}
                >
                    Delete profile picture
                </DangerButton>
            </div>
        </div>
    </Modal>


    <form onsubmit={submit} class="mt-6 space-y-6">
        <div>
            <InputLabel for="name" value="Name" />

            <TextInput
                id="name"
                type="text"
                class="block w-full mt-1"
                bind:value={$form.name}
                required
                autofocus
                autocomplete="name"
            />

            <InputError class="mt-2" message={$form.errors.name} />
        </div>

        <div>
            <InputLabel for="email" value="Email" />

            <TextInput
                id="email"
                disabled={user.provider ? true : false}
                type="email"
                class={`block w-full mt-1 ${user.provider ? 'disabled bg-slate-200' : ''}`}
                bind:value={$form.email}
                required
                autocomplete="username"
                title={user.provider
                    ? `Your account is linked to ${user.provider}, so you cannot change your email through our app.`
                    : ''}
            />

            <InputError class="mt-2" message={$form.errors.email} />
        </div>

        {#if mustVerifyEmail && user.email_verified_at === null}
            <p class="mt-2 text-sm text-gray-800">
                Your email address is unverified.
                <button
                    use:inertia={{
                        href: route('verification.send'),
                        method: 'post',
                    }}
                    class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Click here to re-send the verification email.
                </button>
            </p>

            {#if status === 'verification-link-sent'}
                <div class="mt-2 text-sm font-medium text-green-600">
                    A new verification link has been sent to your email address.
                </div>
            {/if}
        {/if}

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
