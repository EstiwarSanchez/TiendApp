<footer class="fixed p-2 bg-gray-200 bg-opacity-40 r-0 l-0 b-0 text-xs transition-colors font-semibold text-center flex shadow text-gray-700 dark:text-gray-100 dark:bg-gray-700">
    <div class="w-60" x-bind:class="{'hidden' : mobile, 'block' : !mobile}"></div>
    <div class="mx-auto">
        © copyright {{date('Y')}} - {{config('app.name')}} By Yonier.
    </div>
</footer>
