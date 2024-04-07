{{-- show number phone and push name --}}

<span>
    @dump($column->toArray())
    @if ($column->session_push_name)
        <a href="tel:{{ $column->phone_number }}" class="text-blue-500 hover:text-blue-800">{{ $column->session_push_name ?? '---' }}</a>
    @endif
    <span class="text-gray-500">{{ $column->phone_number ?? '---' }}</span>
</span>
