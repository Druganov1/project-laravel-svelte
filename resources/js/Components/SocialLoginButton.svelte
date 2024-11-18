<script>

    import Icon from '@iconify/svelte';
    export let provider;

    const providerColors = {
        github: 'bg-black hover:bg-gray-900',
        google: 'bg-[#dd4e41] hover:bg-red-500',
        facebook: 'bg-blue-600 hover:bg-blue-500',
        twitter: 'bg-blue-400 hover:bg-blue-300',
        discord: 'bg-[#5865f2] hover:bg-[#677bc4]',
        // Add more providers and their colors here
    };

    $: buttonColorClass = providerColors[provider] || 'bg-black'; // Default to black if provider is not found
</script>

<a href={`/auth/${provider}/redirect`} class={`social-button ${buttonColorClass} text-white py-2 px-4 rounded flex justify-center items-center gap-2`}>
    <Icon class="size-7" icon={`mdi:${provider}`} />Sign in with {provider.charAt(0).toUpperCase() + provider.slice(1)}
</a>
