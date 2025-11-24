<?php 
    session_start();
    require_once('dbClass.php');

    $col = isset($_REQUEST['col']) ? $_REQUEST['col'] : '';
    $DesignID = isset($_REQUEST['DesignID']) ? $_REQUEST['DesignID'] : '';

    $data = array();

    switch($col){
        case 'FAC_MTRS':
            $query1 = "select lotno,pcs,BALQTY, DESIGN, QUALITY, grade, ALLOT, godown from tejas_finstk where dsnoid=" . $DesignID ;
            $query2 = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='tejas_finstk' AND A.COLUMN_NAME IN ('lotno','pcs','balqty', 'design', 'quality', 'grade', 'Allot', 'godown' )";
            break;
        case 'PAC_MTRS':
            $query1 = "select ENTRY_NO,CONVERT(nvarchar(10), DATE, 120) AS DATE,LOTNO,REF_BARCODE,METERS,QUALITY_NAME,PCS from tejas_PACKER_STK where designid=" . $DesignID ;
            $query2 = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='tejas_PACKER_STK' AND A.COLUMN_NAME IN ('ENTRY_NO','DATE','LOTNO','REF_BARCODE','METERS','QUALITY_NAME','PCS' )";
            break;
        case 'ORD_MTRS':
            $query1 = "select ORDER_NO, ORDER_DT, PARTY,QUALITY,DESIGN,PCS,BALQTY,BASEDSNOID,ALLOT from TEJAS_BASAB52_SALORD WHERE BASEDSNOID = " . $DesignID ;
            $query2 = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='TEJAS_BASAB52_SALORD' AND A.COLUMN_NAME IN ('ORDER_NO','ORDER_DT','PARTY','QUALITY','DESIGN','PCS','BALQTY','BASEDSNOID','ALLOT' )";
            break;
        case 'DYG_MTRS':
            $query1 = "select ENTRY_NO,ENTDT,LOTNO,PROCESS,PARTY,CHALLAN_NO,TYPE,QUALITYNAME,DESIGN,PCS,MTRS,REC_PCS,RECQTY,BAL_PCS,Bal_Mtrs FROM TEJAS_PROC_BAL WHERE BASEDSNOID = " . $DesignID ;
            $query2 = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='TEJAS_PROC_BAL' AND A.COLUMN_NAME IN ('ENTRY_NO','ENTDT','LOTNO','PROCESS','PARTY','CHALLAN_NO','TYPE','QUALITYNAME','DESIGN','PCS','MTRS','REC_PCS','RECQTY','BAL_PCS','Bal_Mtrs' )";
            break;
        case 'PO_MTRS':
            $query1 = "select ORDER_NO,CONVERT(nvarchar(10), ORDER_DT, 120) AS ORDER_DT,PO_NO,PARTYNAME,QUALITY,DESIGN,PCS,QTY,dsp_qty,BAL_QTY FROM TEJAS_PURORDREG WHERE BASEDSNOID = " . $DesignID ;
            $query2 = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='TEJAS_PURORDREG' AND A.COLUMN_NAME IN ('ORDER_NO','ORDER_DT','PO_NO','PARTYNAME','QUALITY','DESIGN','PCS','QTY','dsp_qty','BAL_QTY')";
            break;
    }
    $result = db::getInstance()->db_select($query1);
    if ($result['num_rows'] > 0) {
        $data['data'] = $result['result_set'];
    }
    $result = db::getInstance()->db_select($query2);
    if ($result['num_rows'] > 0) {
        $data['Structure'] = $result['result_set'];
    }
    echo json_encode($data);
    exit;

?>