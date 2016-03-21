<?php
$sample_form = array(
    'form_id' => 'sample_form',
    'route' => 'users.store',
    'submit' => 'Save',
    'cancel' => true,
    'ajax' => false,
    'fields' => array(
        array(
            'type' => 'text',
            'label' => 'Name',
            'name' => 'name',
        ),
        array(
            'type' => 'password',
            'label' => 'Password',
            'name' => 'password',
        ),
        array(
            'type' => 'email',
            'label' => 'Email',
            'name' => 'email',
        ),
        array(
            'type' => 'heading',
            'content' => 'Credentials',
            'tag' => 'h4',
            'description' => 'Sample heading content',
        ),
        array(
            'type' => 'select',
            'label' => 'Dev',
            'name' => 'dev',
            'options' => array(
                'red' => 'Red',
                'green' => 'Green',
            ),
        ),
        array(
            'type' => 'para',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        ),
        array(
            'type' => 'checkbox',
            'label' => 'Hobbies',
            'name' => 'hobbies',
            'options' => array(
                'red' => 'Red',
                'green' => 'Green',
                'blue' => 'Blue',
            ),
        ),
        array(
            'type' => 'radio',
            'label' => 'Gender',
            'name' => 'gender',
            'options' => array(
                'male' => 'Male',
                'female' => 'Female'
            ),
        )
    )
);
?>


@if ($errors->any())
<div class="alert alert-danger">
    {{ implode('. ', $errors->all(':message')) }}
</div>
@endif


@if(isset($form['method']) && isset($form['model']))
{{ Form::model($form['model'], array('method' => $form['method'], 'route' => array($form['route'], $form['model']->id), 'class'=>'form-horizontal form-label-left', 'id' => $form['form_id'])) }}
{{ Form::hidden('model_id', $form['model']->id) }}
@else
{{ Form::open(array('route' => $form['route'], 'class'=>'form-horizontal form-label-left', 'id' => $form['form_id'])) }}
@endif


@if(isset($form['action']))
{{ Form::hidden('action', $form['action']) }}
@endif

@foreach($form['fields'] as $value)
<div class="form-group">

    <?php extract($value); ?>

    @if(in_array($type, array('heading', 'para')))
    <?php
    switch ($type):
        case 'heading':
            $tag = (isset($tag)) ? $tag : 'h2';
            $head_open = '<' . $tag . '>';
            $head_close = '</' . $tag . '>';

            echo $head_open . $content . $head_close;
            echo (isset($description)) ? '<p>' . $description . '</p>' : '';
            break;
        case 'para':
            echo '<p>' . $content . '</p>';
            break;

    endswitch;
    ?>

    @endif

    @if(in_array($type, array('hidden')))
        {{Form::hidden($name, $value);}}
    @endif
    
    @if(in_array($type, array('text', 'email', 'password', 'select', 'radio', 'checkbox', 'textarea')))

    {{ Form::label($field_id, $label, array('class' => 'control-label col-md-3 col-sm-3 col-xs-12')) }}

    <?php
    switch ($type):
        case 'text':
        case 'hidden':
        case 'email':
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::$type($name, null, array('class' => 'form-control col-md-7 col-xs-12', 'id' => $field_id)) }}
            </div>
            <?php
            break;

        case 'password':
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::$type($name, array('class' => 'form-control col-md-7 col-xs-12', 'id' => $field_id)) }}
            </div>
            <?php
            break;

        case 'select':
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::select($name, $options, null, array('class' => 'form-control col-md-7 col-xs-12', 'id' => $field_id)) }}
            </div>
            <?php
            break;

        case 'radio':
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12 radio">
                @foreach($options as $key => $val)
                <label>
                    {{ Form::radio($name, $key) }}
                    {{ $val }}
                </label>
                @endforeach
            </div>
            <?php
            break;

        case 'checkbox':
            ?>
            <div class="col-sm-9 checkbox">
                @foreach($options as $key => $val)
                <label>
                    {{ Form::checkbox($name . '[]', $key) }}
                    {{ $val }}
                </label>
                @endforeach
            </div>
            <?php
            break;
        
        case 'textarea':
            ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                {{ Form::$type($name, null, array('class' => 'form-control col-md-7 col-xs-12', 'id' => $field_id)) }}
            </div>
            <?php
            break;
    endswitch;
    ?>
    @endif

</div>


@endforeach

<?php $submit_label = (isset($form['submit'])) ? $form['submit'] : 'Submit'; ?>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        @if(isset($form['ajax']) && $form['ajax'])
        <button class="btn btn-info ajax-form-submit">save</button>

        @else
        {{ Form::submit($submit_label, array('class' => 'btn btn-info')) }}
        @endif

        @if(isset($form['cancel']) && $form['cancel'])
        <a href="{{URL::previous()}}" class="btn btn-default">cancel</a>
        @endif
    </div>
</div>

{{ Form::close() }}
