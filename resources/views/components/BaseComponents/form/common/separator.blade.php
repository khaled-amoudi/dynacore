@props(['title' => false])
<div class="mb-7 col-12">
    {{-- <div class="separator border my-10"></div> --}}
    <div class="{{ $title ? 'mt-10' : 'my-10' }}">
        <div>{{ $title }}</div>
        <div class="separator {{ $title ? 'border-secondary' : 'border' }} border separator-dashed"></div>
    </div>
</div>


{{--
USE:
    [
        'formtype' => 'separator',
        'name' => 'separator',
        'title' => 'بيانات العميل'
    ],

--}}
