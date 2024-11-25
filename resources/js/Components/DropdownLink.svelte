<script lang="ts">
    import type { Snippet } from 'svelte';
    import { Link } from '@inertiajs/svelte';

    let {
        children,
        href,
        ...attrs
    }: {
        children: Snippet;
        href: string;
    } = $props();
</script>

<Link
    {...attrs}
    {href}
    class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out text-start dark:text-white dark:hover:bg-gray-500 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none"
>
    {@render children()}
</Link>
