<div class="d-flex flex-wrap">
    @foreach ($registro->files as $file)
        <div class="d-flex m-3 z-depth-2 rounded ">
            <div class="p-2 ml-auto">
                <a href="{{route('media.download',$file->uuid)}}" target="_blank">
                    <p class="small">
                        <span class="red-text">{{$file->document_type->name}}</span>
                        <br>
                        <span>{{$file->observations}}</span>
                        <br>
                        <span>{{$file->created_at->format('d/m/Y')}}</span>
                    </p>
                </a>
            </div>
            @hasanyrole( 'super_admin|admin' )
                <div class="p-2">
                    <a href="{{route('media.delete',$file->uuid)}}" class="red-text">
                        <i class="fa fa-window-close fa-lg"></i>
                    </a>
                </div>
            @endhasanyrole
       </div> 
    @endforeach
</div>