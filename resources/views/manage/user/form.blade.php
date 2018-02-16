<!-- Step 1 -->
<h6>User Data</h6>
<section>
    <div class="form-group row {{ $errors->has('role_nm') ? ' has-error' : '' }}">
        {!! Form::label('nama_lengkap','Nama ',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('nama_lengkap',null,['class' => 'form-control ' , 'required' =>'true']) !!}
            @if ($errors->has('nama_lengkap'))
                <span class="help-block">
                    <strong>{{ $errors->first('nama_lengkap') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('tempat_lahir') ? ' has-error' : '' }}">
        {!! Form::label('tempat_lahir','Tempat Lahir',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('tempat_lahir',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('tempat_lahir'))
                <span class="help-block">
                    <strong>{{ $errors->first('tempat_lahir') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
        {!! Form::label('tanggal_lahir','Tanggal Lahir',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('tanggal_lahir',null,['class' => 'form-control datepicker' ,'required' =>'true']) !!}
            @if ($errors->has('tanggal_lahir'))
                <span class="help-block">
                    <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('no_telp') ? ' has-error' : '' }}">
        {!! Form::label('no_telp','No Telp',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('no_telp',null,['class' => 'form-control ' ,'required' =>'true', 'maxlength' => '16']) !!}
            @if ($errors->has('no_telp'))
                <span class="help-block">
                    <strong>{{ $errors->first('no_telp') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('jabatan') ? ' has-error' : '' }}">
        {!! Form::label('jabatan','Jabatan',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('jabatan',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('jabatan'))
                <span class="help-block">
                    <strong>{{ $errors->first('jabatan') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('alamat') ? ' has-error' : '' }}">
        {!! Form::label('alamat','Alamat',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::textarea('alamat',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('alamat'))
                <span class="help-block">
                    <strong>{{ $errors->first('alamat') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('foto') ? ' has-error' : '' }}">
        {!! Form::label('foto','Foto ',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            @if(! empty($user->foto))
                <div class="col-md-4 ml-0 pl-0 mb-10">
                    Image saat ini  : <img class="img-responsive" src="{{ asset('images/avatar/thumbnail/'.$user->foto) }}" alt="Foto Profil">
                </div>
            @endif
            {!! Form::file('foto',['class' => 'form-control file-styled']) !!}
            @if ($errors->has('foto'))
                <span class="help-block">
                    <strong>{{ $errors->first('foto') }}</strong>
                </span>
            @endif
        </div>
    </div>
</section>
<!-- Step 2 -->
<h6>User Login</h6>
<section>
    <div class="form-group row {{ $errors->has('username') ? ' has-error' : '' }}">
        {!! Form::label('username','Username',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('username',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('email','E-mail',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::email('email',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    @if(! is_null($user->status))
    <div class="form-group row {{ $errors->has('status') ? ' has-error' : '' }}">
        {!! Form::label('status', 'Status' ,['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            <input name="status" type="radio" value="aktif" id="aktif" class="radio-col-teal" {{ ($user->status == 'aktif') ? 'checked' : '' }}>
            <label for="aktif" class="mr-10">Aktif</label>
            <input name="status" type="radio" value="unaktif" id="unaktif" class="radio-col-teal"  {{ ($user->status == 'unaktif') ? 'checked' : '' }}>
            <label for="unaktif">Unaktif</label>
            @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>
    </div>
    @endif
    <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
        {!! Form::label('password','Password',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password',['class' => 'form-control ' , !empty($user) ? ' ': ['required'=>'true']]) !!}
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('password_confirm') ? ' has-error' : '' }}">
        {!! Form::label('password_confirm','Konfirmasi Password',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::password('password_confirm',['class' => 'form-control ' , !empty($user)? '' : ["equalTo" => "#password" ] , !empty($user) ? ' ': ['required'=>'true']]) !!}
            @if ($errors->has('password_confirm'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirm') }}</strong>
                </span>
            @endif
        </div>
    </div>
</section>
<!-- Step 3 -->
<h6>Atur Role</h6>
<section>
    <div class="row mb-10">
        @foreach($listRole as $portal)
            @if(! $portal->role->isEmpty())
                <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
                    <div class="ribbon-wrapper">
                        <div class="ribbon ribbon-bookmark bg-success">{{ $portal->portal_nm }}</div>
                        <div class="ribbon-content">
                            @forelse($portal->role as $role)
                                <div class="row">
                                    <div class="col-md-12">
                                        <input name="role_id[]" type="checkbox" id="role-{{ $role->id }}" class="filled-in chk-col-green" value="{{ $role->id }}"
                                              @if(isset($user->list_role) )
                                                   @foreach($user->list_role as $access)
                                                       @if($role->id == $access->role_id)
                                                            checked
                                                        @endif
                                                    @endforeach
                                               @endif
                                        >
                                        <label for="role-{{ $role->id }}" >{{ $role->role_nm }}</label>
                                    </div>
                                </div>
                            @empty
                                <p>Belum ada role.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>