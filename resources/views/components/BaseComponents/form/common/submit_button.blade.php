@props([
    'text' => 'Save',
    'btn_color' => 'btn-primary',
])

<button class="mb-7 btn {{ $btn_color }} shadow" type="submit">
    <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" viewBox="0 0 24 24" fill="none">
            <path
                d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z"
                fill="black"></path>
        </svg></span>
        {{ __($text) }}
</button>




{{--

<x-BaseComponents.form.common.submit_button
text="save"
btn_color="btn-primary"/>
_______________________________________________________________
<x-BaseComponents.form.common.submit_button />

--}}
