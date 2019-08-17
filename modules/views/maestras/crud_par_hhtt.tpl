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
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_PAR_LUG" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> SITIOS</button>
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_PAR_EQUI" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> EQUIP. TRAB.</button>
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_PAR_ARR" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> ARRIENDOS</button>
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="CRUD_PAR_VEH" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-right"></i></span> VEHICULOS</button>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th>CODIGO</th>
                  <th>SEGMENTO</th>
                  <th>SITIO</th>
                  <th>EQUIP. TRAB.</th>
                  <th># TRABJS</th>
                  <th>HH_NOR</th>
                  <th>HH_EXT</th>
                  <th>OPCS</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr>
                  <td>{codigo}</td>
                  <td>{segmento}</td>
                  <td>{lugar}</td>
                  <td>{equipo}</td>
                  <td>{trabs}</td>
                  <td>{valor_normal}</td>
                  <td>{valor_extra}</td>
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