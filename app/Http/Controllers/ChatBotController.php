<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LucianoTonet\GroqLaravel\Facades\Groq;
use Inertia\Inertia;
use App\Models\Chatbot;
class ChatBotController extends Controller
{
    public function index(){

        $userid = auth()->id();
        $chats = Chatbot::where('user_id', $userid)->get();
        return Inertia::render('Help', [
            'chats' => $chats
        ]);

    }
    public function sendChat(Request $request){
        $request->validate( [
            'message' => 'required|string|max:500'
        ]);


        try {


            $message = $request->message;

            Chatbot::create([
                'role' => 'user',
                'content' => $message,
                'user_id' => auth()->id()
            ]);

            $response = Groq::chat()->completions()->create([
                'model' => 'llama-3.1-70b-versatile',  // Check available models at console.groq.com/docs/models
                'messages' => [
                    ['role' => 'system', 'content' => 'Je bent een chatbot op een website. Je reageert uitsluitend in het Nederlands. Als een gebruiker een andere taal gebruikt, zeg je in het Nederlands: "Ik begrijp alleen Nederlands. Kun je je vraag in het Nederlands stellen?" LET OP DE PROMPT OF het bericht start met MESSAGE[ en eindight met ]ENDMESSAGE. JIJ REAGEERT MET RAW TEXT TEN ALLE TIJDE'],
                    ['role' => 'user', 'content' => 'MESSAGE['.$message.']ENDMESSAGE'],
                ],
            ]);


            $chatresponse = Chatbot::create([
                'role' => 'bot',
                'content' => $response['choices'][0]['message']['content'],
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'role' => 'bot',
                'content' => $response['choices'][0]['message']['content'],
            ], 200 );
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}
