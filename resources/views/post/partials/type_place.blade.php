<div class="form-group {{ $errors->has('metadata.data.phone') ? 'has-error' : ''}}">
    {!! Form::label('phone', 'Phone: ', ['class' => 'control-label']) !!}
    <div class="">
        {!! Form::text('metadata[data][phone][0]', null, ['class' => 'form-control required']) !!}
        {!! $errors->first('metadata.data.phone', '<p class="help-block">:message</p>') !!}
    </div>
    <button type="button" class="btn btn-default add-new-phone" id="add-new-phone">+
    </button>
</div>

<div class="phone">
    <div class="phone-item">
        @if(isset($post))
            @if($post->metadata->type =='place')

                <?php
                $j = 0;
                $phones = $post->metadata->data->phone;
                unset($phones[0])
                ?>
                @foreach($phones as $key=>$phone_title)
                    <div class="form-group {{ $errors->has('metadata.data.phone') ? 'has-error' : ''}}">
                        {!! Form::label('', '', ['class' => 'control-label']) !!}
                        <div class="">
                        {!! Form::text("metadata[data][phone][$key]", $phone_title, ['class' => 'form-control required']) !!}
                    </div>
                        <div data-id="{{$key}}" class="delete delete-old-phone-field btn btn-danger">X</div>
                    </div>
                    <?php $j ++;?>
                @endforeach
            @endif
        @endif
    </div>
</div>


<div class="form-group {{ $errors->has('metadata.address') ? 'has-error' : ''}}">
    {!! Form::label('address', 'Address: ', ['class' => 'control-label']) !!}
    <div class="">
        {!! Form::text('metadata[data][address]', null, ['class' => 'form-control required']) !!}
        {!! $errors->first('metadata.address', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<hr>
@section('script')
<script>
    $(function () {
        var j = {{$j or 0}};
        $('.add-new-phone').on('click', function (e) {
            e.preventDefault();
            j += 1;
            var template = $('#place_phone_field').html();
            Mustache.parse(template);
            var rendered = Mustache.render(template, {count: j});
            $('.phone .phone-item:last-child').append(rendered);

        });

        $(document).on('click', '.delete-phone-field', function (e) {
            e.preventDefault();
            $(this).parent().remove();
            j -= 1;
        });
        $(document).on('click', '.delete-old-phone-field', function (e) {
            e.preventDefault();

        });
    })
</script>
@endsection
