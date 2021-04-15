<template>
    <div class="bg-own relative flex items-center sm:items-top justify-center min-h-screen sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <inertia-link v-if="$page.props.user" href="/dashboard" class="text-sm text-gray-700 underline">
                Dashboard
            </inertia-link>

            <template v-else>
                <inertia-link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </inertia-link>

                <inertia-link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </inertia-link>
            </template>
        </div>

    <div class="">
        <div class="flex justify-center items-baseline">
            <h1 class="text-4xl sm:text-6xl font-bold text-white font-sans lowercase">Start</h1>
            <svg xmlns="http://www.w3.org/2000/svg" class="" width="102" height="102" viewBox="0 0 24 24" stroke-width="0.5" stroke="#059669" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M11 3h10v8h-3l-4 2v-2h-3z" />
                <path d="M15 16v4a1 1 0 0 1 -1 1h-8a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1h2" />
                <path d="M10 18v.01" />
            </svg>
            <h1 class="text-4xl sm:text-6xl -ml-4 font-bold text-white font-sans lowercase">Chat</h1>
        </div>
        <div v-if="$page.props.user" class="mt-10 text-center">
            <a  href="/dashboard" class="text-lg px-6 py-4 hover:text-gray-300 rounded-full font-bold text-gray-50 shadow-2xl border border-gray-800">Dashboard</a> 
        </div>
        
        <div class="text-center mt-10" v-else>
            <a :href="route('login')" class="mr-4 text-lg px-6 py-4 hover:text-gray-300 rounded-full font-bold text-gray-50 shadow-2xl border border-gray-800">Log in</a>
            <span class="text-green-600 font-bold text-lg">OR</span>
            <a v-if="canRegister" :href="route('register')" class="ml-4 text-lg text-gray-50 hover:text-gray-300 px-6 py-4 rounded-full font-bold shadow-2xl bg-gray-800">Register</a>
        </div>
        
    </div>
    </div>
</template>
         
<style scoped>
.bg-own {
  background-color: #2fb7b6;
}
.bg-gray-100 {
  background-color: #f7fafc;
  background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
  border-color: #edf2f7;
  border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
  color: #cbd5e0;
  color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
  color: #a0aec0;
  color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
  color: #718096;
  color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
  color: #4a5568;
  color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
  color: #1a202c;
  color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
  .dark\:bg-gray-800 {
    background-color: #2d3748;
    background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
  }

  .dark\:bg-gray-900 {
    background-color: #1a202c;
    background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
  }

  .dark\:border-gray-700 {
    border-color: #4a5568;
    border-color: rgba(74, 85, 104, var(--tw-border-opacity));
  }

  .dark\:text-white {
    color: #fff;
    color: rgba(255, 255, 255, var(--tw-text-opacity));
  }

  .dark\:text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
  }
}
</style>

<script>
export default {
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
  },
};
</script>
