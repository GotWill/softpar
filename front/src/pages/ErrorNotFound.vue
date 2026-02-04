<template>
  <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center px-6 py-12">
    <div class="text-center">
      <div class="mb-8">
        <h1 class="text-9xl font-extrabold text-indigo-600 tracking-widest">404</h1>
        <div class="bg-indigo-100 px-2 text-sm rounded rotate-12 absolute transform -translate-y-20 translate-x-24">
          Página não encontrada
        </div>
      </div>

      <h2 class="text-3xl font-bold text-gray-800 md:text-4xl mb-4">
        Ops! Você se perdeu no espaço?
      </h2>
      <p class="text-gray-600 mb-8 max-w-md mx-auto">
        A página que você está procurando não existe.
      </p>

      <router-link
        to="/"
        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Voltar para o Início
      </router-link>
    </div>
  </div>
</template>

