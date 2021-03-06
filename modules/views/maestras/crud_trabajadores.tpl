<!-- START BLOCK : module -->
<div class="page-breadcrumb bg-white">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{menu_name}</h5>
        </div>
        <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
            <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                <ol class="breadcrumb mb-0 justify-content-end p-0 bg-white">
                    <li class="breadcrumb-item"><a class="menu" href="javascript:void(0)" data-menu="{mod}" data-mod="{submod}" data-acc="MODULO">{menu_pri}</a></li>
                    <li class="breadcrumb-item"><a class="menu" href="javascript:void(0)" data-menu="{mod}" data-mod="{submod}" data-acc="MODULO">{menu_sec}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{menu_ter}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="material-card card">
        <div class="card-body">
          <h4 class="card-title">{mod_name}</h4>
          <div class="button-group">
              <!-- START BLOCK : data_new -->
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="{ref}" data-subref="{subref}" data-acc="NEW" data-id="0"><span class="btn-label"><i class="fas fa-plus"></i></span> NUEVO</button>
              <!-- END BLOCK : data_new -->
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_CARGOS" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> CARGOS</button>
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_ESPECIALIDADES" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> ESPECIALIDADES</button>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th>CODIGO</th>
                  <th width="75px">RUT</th>
                  <th>TRABAJADOR</th>
                  <th>TELEFONO(S)</th>
                  <th>CARGO</th>
                  <th>ESPECIALIDAD</th>
                  <th>ESTATUS</th>
                  <th>OPC</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr>
                  <td>{codigo}</td>
                  <td>{code}</td>
                  <td>{data}</td>
                  <td>{telefonos}</td>
                  <td>{cargo}</td>
                  <td>{especialidad}</td>
                  <td>{ESTATUS}</td>
                  <td>{actions}</td>
                </tr>
                <!-- END BLOCK : data -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END BLOCK : module -->