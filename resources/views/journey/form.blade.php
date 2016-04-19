<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    {!! Form::label('title', 'Title: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('menu_image') ? 'has-error' : ''}}">
    {!! Form::label('menu_image', 'Menu Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('menu_image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('menu_image', '<p class="help-block">:message</p>') !!}
        @if(isset($journey))
            <img src="{{$journey->menu_image_link}}"/>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('featured_image') ? 'has-error' : ''}}">
    {!! Form::label('featured_image', 'Featured Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('featured_image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('featured_image', '<p class="help-block">:message</p>') !!}
        @if(isset($journey))
            <img src="{{$journey->featured_image_link}}"/>
        @endif
    </div>
</div>
<div class="form-group {{ $errors->has('small_menu_image') ? 'has-error' : ''}}">
    {!! Form::label('small_menu_image', 'Small Menu Image: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::file('small_menu_image', null, ['class' => 'form-control']) !!}
        {!! $errors->first('small_menu_image', '<p class="help-block">:message</p>') !!}
        @if(isset($journey))
            <img src="{{$journey->small_menu_image_link}}"/>
        @endif
    </div>
</div>

<div class="subcategory">
    <button type="button" class="btn btn-default add-new-subcategory" id="add-new-subcategory">Add Sub Category
    </button>
    <div class="subcategory-item">
        @if(isset($journey))
            <?php
            $subCategories = $journey->subCategories->lists('title', 'id')->toArray();
            ?>
            @foreach($subCategories as $key=>$subcategory_title)
                <div class="form-group {{ $errors->has('subcategory') ? 'has-error' : ''}}">
                    {!! Form::label('subcategory', 'Subcategory: ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::text("subcategory_old[$key][title]", $subcategory_title, ['class' => 'form-control required']) !!}
                    </div>
                    <div data-id="{{$key}}" class="delete delete-old-journey-subcategory-field btn btn-danger">X</div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="subcategory-item">
        @if(old('subcategory'))
            <?php
            $subcategorys = empty(old('subcategory')) ? [] : old('subcategory');
            $j = 0;
            ?>
            @foreach($subcategorys as $key=>$subcategory_title)
                <div class="form-group {{ $errors->has('subcategory') ? 'has-error' : ''}}">
                    {!! Form::label('subcategory', 'Subcategory: ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                     {!! Form::text("subcategory[$key][title]", null, ['class' => 'form-control required']) !!}
                </div>
                    <div class="delete delete-journey-subcategory-field btn btn-danger">X</div>
                </div>
                <?php $j ++;?>
            @endforeach
        @endif
    </div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status: ', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        <div class="checkbox">
            <label>{!! Form::radio('status', '1') !!} Yes</label>
        </div>
        <div class="checkbox">
            <label>{!! Form::radio('status', '0', true) !!} No</label>
        </div>
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@include('templates.templates')
@section('script')
    <script type="text/javascript" src="{{ asset('js/mustache.min.js')}}"></script>
    <script>
        $(function () {
            var j = {{$j or 0}};
            $('.add-new-subcategory').on('click', function (e) {
                e.preventDefault();
                j += 1;
                var template = $('#journey_subcategory_field').html();
                Mustache.parse(template);
                var rendered = Mustache.render(template, {count: j});
                $('.subcategory .subcategory-item:last-child').append(rendered);

            });

            $(document).on('click', '.delete-journey-subcategory-field', function (e) {
                e.preventDefault();
                $(this).parent().remove();
                j -= 1;
            });
            $(document).on('click', '.delete-old-journey-subcategory-field', function (e) {
                e.preventDefault();
                var data = {id: $(this).data('id')};
                var self = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{route('journey.subcategory.delete')}}",
                    data: data,
                    success: function (result) {
                        self.parent().remove();
                        App.notify.success('deleted!');
                    }
                });
            });
        });
    </script>
@endsection