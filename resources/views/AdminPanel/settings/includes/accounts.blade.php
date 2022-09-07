<!-- form -->
<div class="row">
    <div class="col-12 col-md-6">
        <label class="form-label" for="TotalMainExpenses">{{trans('common.TotalMainExpenses')}}</label>
        {{Form::text('TotalMainExpenses',getSettingValue('TotalMainExpenses'),['id'=>'TotalMainExpenses','class'=>'form-control'])}}
    </div>
</div>