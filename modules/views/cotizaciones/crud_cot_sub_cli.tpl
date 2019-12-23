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
                    <li class="breadcrumb-item active" aria-current="page">SUB-COTIZACIONES</li>
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
          <h6>
            <p style="margin: .5rem 0;">CLIENTE: <strong>{code} / {data}</strong></p>
            <p style="margin: .5rem 0;">EQUIPO: <strong>{equipo} {marca} {modelo}</strong></p>
            <p style="margin: .5rem 0;">SERIAL: <strong>{serial}</strong></p>
          </h6>
          <div class="d-flex no-block align-items-center pb-3"><div>COTIZACION: <strong>COT-{codigo}</strong></div></div>
          <hr>
          <div class="button-group">
              <button class="btn btn-outline-secondary waves-effect waves-light menu" type="button" data-menu="{mod}" data-mod="{submod}" data-ref="NONE" data-subref="{subref}" data-acc="MODULO" data-id="0"><span class="btn-label"><i class="fas fa-arrow-left"></i></span> VOLVER</button>
          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered table-hover datatables">
              <thead>
                <tr>
                  <th width="75px">SERVICIO</th>
                  <th>TIPO</th>
                  <th>LUGAR</th>
                  <th>EQUIPO TRAB.</th>
                  <th>TOTAL NETO</th>
                  <th>EJECUTIVO</th>
                  <th width="90px">ESTATUS</th>
                  <th width="40px">OPC</th>
                </tr>
              </thead>
              <tbody>
                <!-- START BLOCK : data -->
                <tr class="{estatus}">
                  <td>{correlativo}</td>
                  <td>{tipo}{gar}</td>
                  <td>{lugar}</td>
                  <td>{equipo}</td>
                  <td class="number_cal">{m_neto}</td>
                  <td>{crea_user}</td>
                  <td>{estatus_}</td>
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