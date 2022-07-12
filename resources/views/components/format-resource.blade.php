<div class="grid gap-6 mb-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full">
    @foreach ($format->fields as $key => $field)
    @isset ($field['fields'])
    <div class="col-span-full w-full ">
        <h4 class="mb-4 font-semibold text-center text-xl text-gray-800 dark:text-gray-300 w-full">
            {{$field['title']}}
        </h4>
        <hr class="my-3">
        <div class="grid gap-6 mb-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full">
            @foreach ($field['fields'] as $subfield)
                <x-format-field :field="$subfield" :index="$key" :answer="$answer" />
            @endforeach
        </div>
    </div>
    @else
    <x-format-field :field="$field" :answer="$answer" />
    @endisset
    @endforeach
</div>
