<script lang="ts">
    import { onMount } from 'svelte';
    import { page } from '@inertiajs/svelte';
    import { writable } from 'svelte/store';


    interface ChatMessage {
        content: string;
        role: 'user' | 'bot';
    }

    let message: string = '';
    let chatContainer: HTMLDivElement | null = null;

    // Use props directly from the page store
    const chats = writable<ChatMessage[]>($page.props.chats || []);

    // Scroll to the bottom of the chat container on mount
    onMount(() => {
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    });

    const sendChatMessage = async (e: SubmitEvent) => {
        e.preventDefault();

        if (message.trim() === '') return;

        // Save and reset message input
        const savedMessage = message;
        message = '';

        // Update local chat state
        chats.update((prevChats) => [
            ...prevChats,
            { content: savedMessage, role: 'user' },
        ]);

        try {
            const response = await axios.post(route('api.sendChat'), {
                message: savedMessage,
            });
            chats.update((prevChats) => [...prevChats, response.data]);
        } catch (error) {
            console.error('Error sending message:', error);
        }
    };

    // Scroll to the bottom whenever chats change
    $: chats,
    chatContainer && (chatContainer.scrollTop = chatContainer.scrollHeight);
</script>

<div class="flex flex-col items-center justify-center w-screen h-screen gap-4 bg-slate-900">
    <h1 class="text-4xl font-bold text-white">Vraag het aan onze chatbot</h1>
    <div class="container mx-auto">
        <div class="mx-auto flex h-[700px] w-full max-w-3xl flex-col rounded-lg bg-white shadow-xl">
            <div
                bind:this={chatContainer}
                class="flex-grow p-6 space-y-4 overflow-y-auto"
            >
                {#each $chats as chat, index}
                    <div class={`flex ${chat.role === 'bot' ? 'items-start' : 'items-end justify-end'}`}>
                        <div class={`max-w-lg px-4 py-3 ${chat.role === 'bot' ? 'bg-gray-100 text-gray-900' : 'bg-blue-600 text-white'} rounded-lg`}>
                            {chat.content}
                        </div>
                    </div>
                {/each}
            </div>

            <div class="p-4 border-t border-gray-300">
                <form class="flex items-center space-x-4" on:submit={sendChatMessage}>
                    <input
                        type="text"
                        bind:value={message}
                        maxLength={500}
                        placeholder="Type your message..."
                        class="flex-grow px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <button
                        type="submit"
                        class="px-5 py-3 text-white transition bg-blue-500 rounded-lg hover:bg-blue-600"
                    >
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
