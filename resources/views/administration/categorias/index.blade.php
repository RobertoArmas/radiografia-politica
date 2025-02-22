@extends('layouts.admin')

@section('content')

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Categorias
      <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Categorias</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">

          <!-- /.box-header -->
          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categorias as $i => $categoria)
              @if($i%2==0)
              <tr class="odd gradeA">
                @else
                <tr class="even gradeA">
                  @endif
                  <td>{{$categoria->nombre}} (<?php echo ($categoria->estado == 1) ?  'activo' : 'inactivo'; ?>)</td>

                  <td>
                    <a href="{{URL::to(route('categorias.edit',$categoria->id))}}"><button class="btn btn-primary">Editar</button></a>
                    <!-- <a style="color:#FFFFFF;" href="#" data-toggle="modal" data-target="#myModal" data-whatever="{{$categoria->id}}" data-description="{{$categoria->name}}"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button></a> -->
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box -->

        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <p id="modal-question"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-danger" id="modal-ok-btn">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('scripts')
    <script>
    $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('whatever') // Extract info from data-* attributes
      var description = button.data('description');
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this);
      modal.find('#modal-question').html("¿Desea eliminar <b>" + description + "</b>?");
      modal.find('#modal-ok-btn').click(function(){
        $.ajax({
          url: "{{url('/administration/categorias').'/'}}" + id,
          type:"post",
          cache: false,
          data: {_method: 'delete', _token: "{{ csrf_token() }}"},
          success:function(res)
          {
            console.log(res);
            location.reload();
          },
          error: function(error)
          {
            if(JSON.parse(error.responseText).message = "Not authorized.")
            {
              swal("Error", "No tiene autorización", "error");
            }
          }
        });
      });
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
      $(this).find('#modal-ok-btn').unbind('click');
    });
    </script>
@endsection
