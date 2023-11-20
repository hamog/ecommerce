<div
    {{ stimulus_controller('flash', [
        'success' => session()->get('success') ?? '',
        'error' => session()->get('error') ?? $errors->any() ? 'Something went wrong' : '',
    ]) }}>

</div>
