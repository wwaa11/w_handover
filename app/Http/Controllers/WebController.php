<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function Fullname($first, $last)
    {
        mb_internal_encoding('UTF-8');
        $setname = mb_substr($first, 1);
        $setlast = mb_substr($last, 1);
        if (str_contains($setname, '\\')) {
            $setname = explode("\\", $setname);
            $setname = $setname[0];
        }
        $name = $setname . " " . $setlast;

        return $name;
    }
    public function FulldateTH($date)
    {
        $dateTime = strtotime($date);

        $day   = date('d', $dateTime);
        $month = date('m', $dateTime);
        $year  = date('Y', $dateTime);

        switch ($month) {
            case '01':
                $fullmonth = "มกราคม";
                break;
            case '02':
                $fullmonth = "กุมภาพันธ์";
                break;
            case '03':
                $fullmonth = "มีนาคม";
                break;
            case '04':
                $fullmonth = "เมษายน";
                break;
            case '05':
                $fullmonth = "พฤษภาคม";
                break;
            case '06':
                $fullmonth = "มิถุนายน";
                break;
            case '07':
                $fullmonth = "กรกฎาคม";
                break;
            case '08':
                $fullmonth = "สิงหาคม";
                break;
            case '09':
                $fullmonth = "กันยายน";
                break;
            case '10':
                $fullmonth = "ตุลาคม";
                break;
            case '11':
                $fullmonth = "พฤศจิกายน";
                break;
            case '12':
                $fullmonth = "ธันวาคม";
                break;
        }
        $year = $year + 543;

        $birthDate = date_create($date);
        $nowDate   = date_create(date('Y-m-d'));
        $diff      = $birthDate->diff($nowDate);

        $data = [
            'date' => $day . " " . $fullmonth . " " . $year,
            'age'  => $diff->y . ' ปี ' . $diff->m . ' เดือน',
        ];

        return $data;
    }
    public function DoctorName($code, $array)
    {
        $name   = $code;
        $Doctor = collect($array)->where('Doctor', $code)->first();
        if ($Doctor) {
            mb_internal_encoding('UTF-8');
            $name = mb_substr($Doctor->LocalName, 1);
            if (str_contains($name, '\\')) {
                $name = explode("\\", $name);
                $name = $name[1] . $name[0];
            }
        }

        return $name;
    }
    public function ClinicName($code, $array)
    {
        $Clinic = collect($array)->where('Code', $code)->first();
        if ($Clinic !== null) {
            mb_internal_encoding('UTF-8');
            $name = mb_substr($Clinic->LocalName, 1);
        } else {
            $name = $code;
        }

        return $name;
    }
    public function ProcedureName($code, $array)
    {
        $Procedure = collect($array)->where('Code', $code)->first();
        mb_internal_encoding('UTF-8');
        $name = mb_substr($Procedure->LocalName, 1);

        return $name;
    }
    public function setTime($prescript, $closeVisit)
    {
        if ($closeVisit == '9') {
            $time = date('H:i', strtotime($prescript->NurseReleaseDateTime));
        } elseif ($prescript->ApprovedDateTime != null) {
            $time = date('H:i', strtotime($prescript->ApprovedDateTime));
        } elseif ($prescript->SendToDiagRmsDateTime != null) {
            $time = date('H:i', strtotime($prescript->SendToDiagRmsDateTime));
        } elseif ($prescript->NurseAckDateTime != null) {
            $time = date('H:i', strtotime($prescript->NurseAckDateTime));
        } elseif ($prescript->NurseReleaseDateTime != null) {
            $time = date('H:i', strtotime($prescript->NurseReleaseDateTime));
        } elseif ($prescript->MakeDateTime != null) {
            $time = date('H:i', strtotime($prescript->MakeDateTime));
        } else {
            $time = null;
        }
        return $time;
    }
    public function setAssessmentText($value, $type)
    {
        switch ($type) {
            case 'isolation':
                switch ($value) {
                    case '01':
                        $text = 'Standard';
                        break;
                    case '02':
                        $text = 'Airbone>ER';
                        break;
                    case '03':
                        $text = 'Droplet';
                        break;
                    case '04':
                        $text = 'Contact';
                        break;
                    default:
                        $text = 'Standard';
                        break;
                }
                break;
            case 'consciousness':
                switch ($value) {
                    case '03':
                        $text = 'Alert';
                        break;
                    case '04':
                        $text = 'Confused';
                        break;
                    case '05':
                        $text = 'Drowsy';
                        break;
                    default:
                        $text = 'Alert';
                        break;
                }
                break;
            case 'fall':
                switch ($value) {
                    case '01':
                        $text = 'None';
                        break;
                    case '02':
                        $text = 'High';
                        break;
                    default:
                        $text = 'None';
                        break;
                }
                break;
        }

        return $text;
    }
    public function setCloseVisit($visitcode)
    {

        if ($visitcode === "0") {
            $code = "ไม่มีค่าใช้จ่าย";
        } elseif ($visitcode === "001") {
            // $code = "Next Clinic";
            $code = "hide";
        } elseif ($visitcode === "002") {
            $code = "ไปห้องยา 1";
        } elseif ($visitcode === "01") {
            $code = "ไปห้องยา 2";
        } elseif ($visitcode === "02") {
            $code = "ไปห้องยา 3";
        } elseif ($visitcode === "03") {
            $code = "ไปห้องยา 5";
        } elseif ($visitcode === "04") {
            $code = "ไปห้องยา 9";
        } elseif ($visitcode === "041") {
            $code = "ไปห้องยาชั้น 8 ตึก B";
        } elseif ($visitcode === "042") {
            $code = "ไปห้องยาชั้น 10 ตึก B";
        } elseif ($visitcode === "049") {
            $code = "ไปการเงิน 1";
        } elseif ($visitcode === "05") {
            $code = "ไปการเงิน 2";
        } elseif ($visitcode === "06") {
            $code = "ไปการเงิน 3";
        } elseif ($visitcode === "07") {
            $code = "ไปการเงิน 5";
        } elseif ($visitcode === "08") {
            $code = "ไปการเงิน 9";
        } elseif ($visitcode === "09") {
            $code = "ไปการเงิน 8";
        } elseif ($visitcode === "10") {
            $code = "ไปการเงิน 0";
        } elseif ($visitcode === "101") {
            $code = "การเงินนอกชั้น  8 ตึก B";
        } elseif ($visitcode === "102") {
            $code = "การเงินนอกชั้น 10 ตึก B";
        } elseif ($visitcode === "103") {
            $code = "การเงินนอกชั้น 12 ตึก B";
        } elseif ($visitcode === "11") {
            $code = "ไปห้องยา(แพทย์ไม่คีย์ยา)";
        } elseif ($visitcode === "110") {
            $code = "ไปห้องยา 1 (แพทย์ไม่คีย์ยา)";
        } elseif ($visitcode === "111") {
            $code = "ไปห้องยาตึก B  (แพทย์ไม่คีย์ยา)";
        } elseif ($visitcode === "12") {
            // $code = "Consult & Out";
            $code = "hide";
        } elseif ($visitcode === "14") {
            $code = "ไปห้องยา(ไตเทียม)";
        } elseif ($visitcode === "15") {
            $code = "ย้าย...ไปรักษาต่อ รพ.อื่น (ห้องยาชั้น 2)";
        } elseif ($visitcode === "16") {
            $code = "เสียชีวิตก่อนถึงโรงพยาบาล";
        } elseif ($visitcode === "17") {
            $code = "ไปห้องยา (กรุงศรี/เพลินจิต)";
        } elseif ($visitcode === "25") {
            $code = "เสียชีวิต";
        } elseif ($visitcode === "9") {
            $code = "รับเป็นผู้ป่วยใน";
            // $code = "hide";
        } elseif ($visitcode === "99") {
            $code = "ยกเลิกใบยา";
        } else {
            $code = "ไม่พบ Code";
        }

        return $code;
    }
    public function index()
    {

        return view('index');
    }
    public function searchHN(Request $req)
    {
        $hn   = $req->hn;
        $date = $req->date;

        $getVN = DB::connection('SSB')
            ->table('HNOPD_MASTER')
            ->join('HNPAT_NAME', 'HNOPD_MASTER.HN', 'HNPAT_NAME.HN')
            ->join('HNPAT_INFO', 'HNOPD_MASTER.HN', 'HNPAT_INFO.HN')
            ->where('HNPAT_NAME.SuffixSmall', '0')
            ->whereDate('HNOPD_MASTER.Visitdate', $date)
            ->where('HNOPD_MASTER.HN', $hn)
            ->select(
                'HNOPD_MASTER.VN',
                'HNOPD_MASTER.HN',
                'HNPAT_NAME.FirstName',
                'HNPAT_NAME.LastName',
                'HNPAT_INFO.BirthDateTime',
            )
            ->get();

        if (count($getVN) > 0) {
            $data = [];
            foreach ($getVN as $vn) {
                $dob            = $this->FulldateTH($vn->BirthDateTime);
                $data['status'] = 'success';
                $data['name']   = $this->Fullname($vn->FirstName, $vn->LastName);
                $data['dob']    = $dob['date'];
                $data['vn'][]   = $vn->VN;
            }
        } else {
            $data = [
                'status'  => 'failed',
                'message' => 'Not found VN for ' . $hn . ' : ' . count($getVN),
            ];
        }

        return response()->json($data, 200);
    }
    public function searchVN(Request $req)
    {
        $date = $req->date;
        $vn   = $req->vn;

        $getVN = DB::connection('SSB')
            ->table('HNOPD_MASTER')
            ->join('HNPAT_NAME', 'HNOPD_MASTER.HN', 'HNPAT_NAME.HN')
            ->join('HNPAT_INFO', 'HNOPD_MASTER.HN', 'HNPAT_INFO.HN')
            ->where('HNPAT_NAME.SuffixSmall', '0')
            ->whereDate('HNOPD_MASTER.Visitdate', $date)
            ->where('HNOPD_MASTER.VN', $vn)
            ->select(
                'HNOPD_MASTER.VN',
                'HNOPD_MASTER.HN',
                'HNPAT_NAME.FirstName',
                'HNPAT_NAME.LastName',
                'HNPAT_INFO.BirthDateTime',
            )
            ->first();

        if ($getVN !== null) {
            $dob  = $this->FulldateTH($getVN->BirthDateTime);
            $data = [
                'status' => 'success',
                'hn'     => $getVN->HN,
                'name'   => $this->Fullname($getVN->FirstName, $getVN->LastName),
                'dob'    => $dob['date'],
            ];

        } else {
            $data = [
                'status'  => 'failed',
                'message' => 'VN: ' . $vn . ' Date : ' . $date . ' Data : ' . json_encode($getVN),
            ];
        }

        return response()->json($data, 200);
    }
    public function result(Request $req)
    {
        $showDebug = false;
        $parameter = $req->query;
        foreach ($parameter as $in => $value) {
            if ($in == 'date') {
                $date = $value;
            }
            if ($in == 'vn') {
                $vn = $value;
            }
            if ($in == 'debug') {
                if ($value == 'true') {
                    $showDebug = true;
                }
            }
        }
        $data = [
            'result' => false,
            'query'  => [
                'vn'   => $vn,
                'date' => $date,
            ],
        ];
        if ($vn == null) {
            $req->session()->flash('status', 'ไม่พบหมายเลข VN นี้');

            return view('result')->with(compact('data'));
        }

        $master = DB::connection('SSB')->table('HNOPD_MASTER')
            ->join('HNPAT_INFO', 'HNOPD_MASTER.HN', 'HNPAT_INFO.HN')
            ->join('HNPAT_NAME', 'HNOPD_MASTER.HN', 'HNPAT_NAME.HN')
            ->whereDate('Visitdate', $date)
            ->where('VN', $vn)
            ->where('HNPAT_NAME.SuffixSmall', 0)
            ->first();
        if ($master == null) {
            $req->session()->flash('status', 'ไม่พบหมายเลข VN นี้');

            return view('result')->with(compact('data'));
        }

        $Clinics = DB::connection('SSB')->table('DNSYSCONFIG')
            ->where('CtrlCode ', 42203)
            ->select('CtrlCode', 'Code', 'LocalName')
            ->get();
        $Doctors = DB::connection('SSB')->table('HNDOCTOR_MASTER')
            ->select('Doctor', 'LocalName')
            ->get();
        $Procedures = DB::connection('SSB')->table('DNSYSCONFIG')
            ->select('LocalName', 'CtrlCode', 'Code')
            ->where('CtrlCode ', 42211)
            ->get();

        $hn = $master->HN;
        $vn = $master->VN;

        $allergic = DB::connection('SSB')->table("HNPAT_ALLERGIC")->where('HN', $hn)->first();
        if ($allergic == null) {
            $allergic = 'Unknow(ไม่เคยซักประวัติ)';
        } else {
            if ($allergic->PharmacoIndex == 99 || $allergic->AdditionPharmacoIndexColl == 99 || $allergic->AdverseReactions1 == 999 || $allergic->InactiveDate != null) {
                $allergic = "ไม่เคยแพ้ยา";
            } else {
                $allergic = "แพ้ยา";
            }
        }

        $birthDate      = $this->FulldateTH($master->BirthDateTime);
        $data['result'] = true;
        $data['debug']  = $showDebug;
        $data['info']   = [
            'visit'    => $this->FulldateTH($date),
            'vn'       => $master->VN,
            'hn'       => $master->HN,
            'name'     => $this->Fullname($master->FirstName, $master->LastName),
            'allergic' => $allergic,
            'gender'   => ($master->Gender == 1) ? 'หญิง' : 'ชาย',
            'dob'      => $birthDate['date'],
            'age'      => $birthDate['age'],
        ];
        $data['situation']  = [];
        $data['background'] = [];
        $data['assessment'] = [];
        $data['closeVisit'] = [];
        $data['memo']       = [];

        $Prescripts = DB::connection('SSB')->table('HNOPD_PRESCRIP')
            ->leftJoin('HNAPPMNT_HEADER', 'HNOPD_PRESCRIP.AppointmentNo', 'HNAPPMNT_HEADER.AppointmentNo')
            ->leftJoin('HNAPPMNT_MSG', 'HNOPD_PRESCRIP.AppointmentNo', 'HNAPPMNT_MSG.AppointmentNo')
            ->whereDate('HNOPD_PRESCRIP.VisitDate', $date)
            ->where('HNOPD_PRESCRIP.VN', $vn)
            ->select(
                'HNOPD_PRESCRIP.PrescriptionNo as No',
                'HNOPD_PRESCRIP.VN',
                'HNOPD_PRESCRIP.Clinic',
                'HNOPD_PRESCRIP.Doctor',
                'HNOPD_PRESCRIP.VisitCode',
                'HNOPD_PRESCRIP.SymptomaticCode',
                'HNOPD_PRESCRIP.VisitPurposeCode',
                'HNOPD_PRESCRIP.EscortCode',
                'HNOPD_PRESCRIP.PatientInfoByRemarks as Recommend',
                'HNOPD_PRESCRIP.MakeDateTime',
                'HNOPD_PRESCRIP.ApprovedDateTime',
                'HNOPD_PRESCRIP.NurseAckDateTime',
                'HNOPD_PRESCRIP.NurseReleaseDateTime',
                'HNOPD_PRESCRIP.SendToDiagRmsDateTime',
                'HNOPD_PRESCRIP.RefFromICDRemarks',
                'HNOPD_PRESCRIP.CloseVisitCode',
                'HNOPD_PRESCRIP.Clinic',
                'HNOPD_PRESCRIP.RemarksMemo as PrescriptMemo',
                'HNAPPMNT_HEADER.AppmntProcedureCode1',
                'HNAPPMNT_HEADER.AppmntProcedureCode2',
                'HNAPPMNT_HEADER.AppmntProcedureCode3',
                'HNAPPMNT_HEADER.AppmntProcedureCode4',
                'HNAPPMNT_HEADER.AppmntProcedureCode5',
                'HNAPPMNT_MSG.HNAppointmentMsgType',
                'HNAPPMNT_MSG.RemarksMemo as AppointmentMemo',
            )
            ->orderBy('HNOPD_PRESCRIP.PrescriptionNo', 'ASC')
            ->orderBy('HNAPPMNT_MSG.HNAppointmentMsgType', 'ASC')
            ->get();
        if ($showDebug) {
            dump('Prescripts');
            dump($Prescripts);
        }
        foreach ($Prescripts as $prescript) {
            $prescript->Clinic                                                             = $this->ClinicName($prescript->Clinic, $Clinics);
            $prescript->Doctor                                                             = $this->DoctorName($prescript->Doctor, $Doctors);
            ($prescript->NurseAckDateTime !== null) ? $prescript->NurseAckDateTime         = $prescript->NurseReleaseDateTime : null;
            ($prescript->AppmntProcedureCode1 !== null) ? $prescript->AppmntProcedureCode1 = $this->ProcedureName($prescript->AppmntProcedureCode1, $Procedures) : $prescript->AppmntProcedureCode1 = null;
            ($prescript->AppmntProcedureCode2 !== null) ? $prescript->AppmntProcedureCode2 = $this->ProcedureName($prescript->AppmntProcedureCode2, $Procedures) : $prescript->AppmntProcedureCode2 = null;
            ($prescript->AppmntProcedureCode3 !== null) ? $prescript->AppmntProcedureCode3 = $this->ProcedureName($prescript->AppmntProcedureCode3, $Procedures) : $prescript->AppmntProcedureCode3 = null;
            ($prescript->AppmntProcedureCode4 !== null) ? $prescript->AppmntProcedureCode4 = $this->ProcedureName($prescript->AppmntProcedureCode4, $Procedures) : $prescript->AppmntProcedureCode4 = null;
            ($prescript->AppmntProcedureCode5 !== null) ? $prescript->AppmntProcedureCode5 = $this->ProcedureName($prescript->AppmntProcedureCode5, $Procedures) : $prescript->AppmntProcedureCode5 = null;

            $SituationText = '';
            if ($prescript->PrescriptMemo !== null) {
                $SituationText .= $prescript->PrescriptMemo . ' ';
            }
            if ($SituationText !== '') {
                $data['situation'][$prescript->No] = [
                    'clinic' => $prescript->Clinic,
                    'doctor' => $prescript->Doctor,
                    'text'   => $SituationText,
                ];
            }

            $BackgroundText = '';
            if ($prescript->AppmntProcedureCode1 !== null) {
                $BackgroundText .= $prescript->AppmntProcedureCode1 . ' ';
            }
            if ($prescript->AppmntProcedureCode2 !== null) {
                $BackgroundText .= $prescript->AppmntProcedureCode2 . ' ';
            }
            if ($prescript->AppmntProcedureCode3 !== null) {
                $BackgroundText .= $prescript->AppmntProcedureCode3 . ' ';
            }
            if ($prescript->AppmntProcedureCode4 !== null) {
                $BackgroundText .= $prescript->AppmntProcedureCode4 . ' ';
            }
            if ($prescript->AppmntProcedureCode5 !== null) {
                $BackgroundText .= $prescript->AppmntProcedureCode5 . ' ';
            }
            $data['background'][$prescript->No] = [
                'suffix'    => $prescript->No,
                'clinic'    => $prescript->Clinic,
                'doctor'    => $prescript->Doctor,
                'procedure' => $BackgroundText,
                'text'      => ($prescript->HNAppointmentMsgType == 5) ? $prescript->AppointmentMemo : null,
            ];

            $recommendText = '';
            if ($prescript->Recommend !== null) {
                $recommendText = $prescript->Recommend;
            }

            $data['assessment'][$prescript->No] = [
                'type'      => 'prescript',
                'time'      => $this->setTime($prescript, $prescript->CloseVisitCode),
                'clinic'    => $prescript->Clinic,
                'doctor'    => $prescript->Doctor,
                'recommend' => $recommendText . ' ' . $BackgroundText,
                'iso'       => $this->setAssessmentText($prescript->SymptomaticCode, 'isolation'),
                'con'       => $this->setAssessmentText($prescript->EscortCode, 'consciousness'),
                'fall'      => $this->setAssessmentText($prescript->VisitPurposeCode, 'fall'),
                'status'    => null,
            ];

            if ($prescript->CloseVisitCode !== null && $prescript->CloseVisitCode !== '001' && $prescript->CloseVisitCode !== '12') {
                $data['closeVisit'][] = [
                    'code'        => $prescript->CloseVisitCode,
                    'time'        => $this->setTime($prescript, $prescript->CloseVisitCode),
                    'destination' => $this->setCloseVisit($prescript->CloseVisitCode),
                ];
            }

            if ($prescript->RefFromICDRemarks !== null) {
                $data['memo'][$prescript->No] = [
                    'no'   => $prescript->No,
                    'memo' => $prescript->RefFromICDRemarks,
                ];
            }
        }

        $Vitalsigns = DB::connection('SSB')->table('HNOPD_VITALSIGN')
            ->whereDate('Visitdate', $date)
            ->where('VN', $Prescripts[0]->VN)
            ->select(
                'HNOPD_VITALSIGN.EntryDateTime',
                'HNOPD_VITALSIGN.SuffixTiny',
                'HNOPD_VITALSIGN.EntryByUserCode',
                'HNOPD_VITALSIGN.BodyWeight',
                'HNOPD_VITALSIGN.Height',
                'HNOPD_VITALSIGN.Temperature',
                'HNOPD_VITALSIGN.PulseRate',
                'HNOPD_VITALSIGN.RespirationRate',
                'HNOPD_VITALSIGN.BpSystolic',
                'HNOPD_VITALSIGN.BpDiastolic',
                'HNOPD_VITALSIGN.PainScale',
                'HNOPD_VITALSIGN.O2Sat',
                'HNOPD_VITALSIGN.Remarks',
            )
            ->get();
        if ($showDebug) {
            dump('Vitalsigns');
            dump($Vitalsigns);
        }
        foreach ($Vitalsigns as $indexVs => $vs) {
            $bmi = null;
            if (round($vs->BodyWeight, 2) > 0 && $vs->Height > 0) {
                $vs->Height = round($vs->Height / 100, 2);
                $bmi        = round($vs->BodyWeight / ($vs->Height * $vs->Height), 2);
            }
            $data['assessment'][] = [
                'type'        => 'vs',
                'time'        => date('H:i', strtotime($vs->EntryDateTime . ' -1 minutes')),
                'clinic'      => ($vs->SuffixTiny == 1) ? 'Vital Sign แรกรับ' : 'Vital Sign',
                'temperature' => round($vs->Temperature, 2),
                'pulse'       => $vs->PulseRate,
                'respiration' => $vs->RespirationRate,
                'bpsys'       => $vs->BpSystolic,
                'bpdias'      => $vs->BpDiastolic,
                'o2sat'       => $vs->O2Sat,
                'bmi'         => $bmi,
                'pain'        => ($vs->PainScale == 0) ? 'N/A' : $vs->PainScale,
                'memo'        => $vs->Remarks,
                'user'        => $vs->EntryByUserCode,
            ];

            if ($indexVs + 1 == count($Vitalsigns)) {
                $data['assessment'][] = [
                    'type' => 'vs_notification',
                    'time' => date('H:i', strtotime($vs->EntryDateTime . '+4 hours')),
                ];
            }
        }

        $Labs = DB::connection('SSB')->table('HNLABREQ_HEADER')
            ->leftJoin('HNLABREQ_LOG', 'HNLABREQ_HEADER.RequestNo', 'HNLABREQ_LOG.RequestNo')
            ->leftJoin('HNLABREQ_MEMO', 'HNLABREQ_HEADER.RequestNo', 'HNLABREQ_MEMO.RequestNo')
            ->leftJoin('HNLABREQ_CHARGE', 'HNLABREQ_HEADER.RequestNo', 'HNLABREQ_CHARGE.RequestNo')
            ->where('HNLABREQ_HEADER.HN', $hn)
            ->where('HNLABREQ_LOG.HNLABRequestLogType', 25)
            ->where('HNLABREQ_CHARGE.SuffixTiny', 1)
            ->select(
                'HNLABREQ_HEADER.CxlDateTime',
                'HNLABREQ_HEADER.EntryDateTime',
                'HNLABREQ_HEADER.AppointmentDateTime',
                'HNLABREQ_HEADER.SpecimenReceiveDateTime',
                'HNLABREQ_HEADER.Ward',
                'HNLABREQ_HEADER.FacilityRmsNo',
                'HNLABREQ_HEADER.RequestNo',
                'HNLABREQ_HEADER.AppointmentNo',
                'HNLABREQ_HEADER.RequestDoctor',
                'HNLABREQ_HEADER.Clinic',
                'HNLABREQ_LOG.HNLABRequestLogType',
                'HNLABREQ_LOG.MakeDateTime',
                'HNLABREQ_MEMO.HNLABRequestMemoType',
                'HNLABREQ_MEMO.RemarksMemo',
                'HNLABREQ_CHARGE.ChargeDateTime'
            )
            ->get();
        if ($showDebug) {
            dump('LAB');
            dump($Labs);
        }
        foreach ($Labs as $indexLab => $lab) {
            $lab->Clinic                                                         = $this->ClinicName($lab->Clinic, $Clinics);
            $lab->RequestDoctor                                                  = $this->DoctorName($lab->RequestDoctor, $Doctors);
            $lab->EntryDateTime                                                  = date('Y-m-d', strtotime($lab->EntryDateTime));
            $lab->SpecimenReceiveDate                                            = null;
            ($lab->SpecimenReceiveDateTime !== null) ? $lab->SpecimenReceiveDate = date('Y-m-d', strtotime($lab->SpecimenReceiveDateTime)) : null;
            $lab->AppointmentDate                                                = null;
            ($lab->AppointmentDateTime !== null) ? $lab->AppointmentDate         = date('Y-m-d', strtotime($lab->AppointmentDateTime)) : null;

            $labToday       = false;
            $labCase        = null;
            $labAppointment = '';
            switch ($lab) {
                case $lab->Ward == null && $lab->EntryDateTime == $date && $lab->AppointmentNo == null:
                    $labToday = true;
                    $labCase  = 1;
                    break;
                case $lab->Ward == null && $lab->EntryDateTime == $date && $lab->EntryDateTime == $lab->SpecimenReceiveDate:
                    $labToday = true;
                    $labCase  = 2;
                    break;
                case $lab->Ward == null && $lab->AppointmentDate == $date && $lab->SpecimenReceiveDate == $date:
                    $labToday       = true;
                    $labAppointment = '(A)';
                    $labCase        = 3;
                    break;
                case $lab->Ward == null && $lab->AppointmentDate !== null && $lab->SpecimenReceiveDate == $date:
                    $labAppointment = '(A)';
                    $labToday       = true;
                    $labCase        = 4;
                    break;
            }
            if ($showDebug && $labToday) {
                dump($indexLab . ' Case : ' . $labCase);
            }
            if ($labToday) {
                $status = null;
                if ($lab->SpecimenReceiveDateTime !== null) {
                    $status = 'SUCCESS';
                }
                if ($lab->CxlDateTime !== null) {
                    $status = 'Cxl';
                }
                if ($lab->FacilityRmsNo == "DIET") {
                    $lab->Clinic = "Consult นักโภชนาการ";
                }

                try {
                    $oldMemo = $data['assessment'][$lab->RequestNo]['memo'];
                } catch (\Throwable $th) {
                    $oldMemo = '-';
                }

                $data['assessment'][$lab->RequestNo] = [
                    'type'      => 'lab',
                    'requestno' => $lab->RequestNo,
                    'time'      => ($labAppointment == '') ? date('H:i', strtotime($lab->MakeDateTime)) : date('H:i', strtotime($lab->ChargeDateTime)),
                    'clinic'    => "LAB : " . $lab->Clinic . ' ' . $labAppointment,
                    'doctor'    => $lab->RequestDoctor,
                    'recommend' => null,
                    'status'    => $status,
                    'memo'      => ($lab->RemarksMemo !== null && $lab->HNLABRequestMemoType == 1) ? $lab->RemarksMemo : $oldMemo,
                ];
            }
        }

        $Xrays = DB::connection('SSB')->table('HNXRAYREQ_HEADER')
            ->leftJoin('HNXRAYREQ_MEMO', 'HNXRAYREQ_HEADER.RequestNo', 'HNXRAYREQ_MEMO.RequestNo')
            ->leftJoin('HNXRAYREQ_CHARGE', 'HNXRAYREQ_HEADER.RequestNo', 'HNXRAYREQ_CHARGE.RequestNo')
            ->where('HNXRAYREQ_HEADER.HN', $hn)
            ->select(
                'HNXRAYREQ_HEADER.CxlDateTime',
                'HNXRAYREQ_HEADER.EntryDateTime',
                'HNXRAYREQ_HEADER.AppointmentDateTime',
                'HNXRAYREQ_HEADER.AcknowledgeDateTime',
                'HNXRAYREQ_HEADER.ResultDateTime',
                'HNXRAYREQ_HEADER.AcknowledgeFlag',
                'HNXRAYREQ_CHARGE.ChargeDateTime',
                'HNXRAYREQ_HEADER.DispatchFlimToDoctor',
                'HNXRAYREQ_HEADER.FixedDFResultDoctor',
                'HNXRAYREQ_HEADER.FacilityRmsNo',
                'HNXRAYREQ_HEADER.Clinic',
                'HNXRAYREQ_HEADER.Ward',
                'HNXRAYREQ_HEADER.RequestNo',
                'HNXRAYREQ_HEADER.RequestDoctor',
                'HNXRAYREQ_HEADER.AppointmentNo',
                'HNXRAYREQ_MEMO.HNXRayRequestMemoType',
                'HNXRAYREQ_MEMO.RemarksMemo',
            )
            ->orderBy('HNXRAYREQ_HEADER.EntryDateTime', 'DESC')
            ->get();
        if ($showDebug) {
            dump('Xrays');
            dump($Xrays);
        }
        foreach ($Xrays as $indexXray => $xray) {
            $xray->Clinic          = $this->ClinicName($xray->Clinic, $Clinics);
            $xray->RequestDoctor   = $this->DoctorName($xray->RequestDoctor, $Doctors);
            $xray->EntryTime       = date('H:i', strtotime($xray->EntryDateTime));
            $xray->EntryDateTime   = date('Y-m-d', strtotime($xray->EntryDateTime));
            $xray->AppointmentDate = null;
            $xray->AppointmentTime = null;
            if ($xray->AppointmentDateTime !== null) {
                $xray->AppointmentDate = date('Y-m-d', strtotime($xray->AppointmentDateTime));
                $xray->AppointmentTime = date('H:i', strtotime($xray->AppointmentDateTime));
            }
            $xray->AcknowledgeDate = null;
            $xray->AcknowledgeTime = null;
            if ($xray->AcknowledgeDateTime !== null) {
                $xray->AcknowledgeTime = date('H:i', strtotime($xray->AcknowledgeDateTime));
                $xray->AcknowledgeDate = date('Y-m-d', strtotime($xray->AcknowledgeDateTime));
            }

            $xrayToday       = false;
            $xrayCase        = null;
            $xrayAppointment = '';
            switch ($xray) {
                // case $xray->EntryDateTime == $date && $xray->AppointmentNo == null && $xray->AcknowledgeFlag == 1:
                case $xray->Ward == null && $xray->EntryDateTime == $date && $xray->AppointmentNo == null:
                    $xrayToday = true;
                    $xrayCase  = 1;
                    break;
                case $xray->Ward == null && $xray->AcknowledgeDate == $date && $xray->AppointmentDate == $date:
                    $xrayToday       = true;
                    $xrayAppointment = '(A)';
                    $xrayCase        = 2;
                    break;
                case $xray->Ward == null && $xray->AcknowledgeDate == $date && $xray->AppointmentDate !== null:
                    $xrayToday       = true;
                    $xrayAppointment = '(A)';
                    $xrayCase        = 3;
                    break;
                case $xray->Ward == null && $xray->EntryDateTime == $date && $xray->FacilityRmsNo == 'INV':
                    $xrayToday = true;
                    $xrayCase  = 4;
                    break;
            }
            if ($showDebug && $xrayToday) {
                dump($indexXray . ' Case : ' . $xrayCase);
            }
            if ($xrayToday) {
                $status = null;
                if ($xray->FacilityRmsNo == 'INV') {
                    $time = date('H:i', strtotime($xray->ChargeDateTime));
                } else {
                    $time = date('H:i', strtotime($xray->EntryTime));
                }
                if ($xrayAppointment == '(A)') {
                    $time = $xray->AppointmentTime;
                }
                if ($xray->DispatchFlimToDoctor == 1) {
                    $status = 'SUCCESS';
                }
                if ($xray->FacilityRmsNo == 'INV' && $xray->ResultDateTime !== null) {
                    $status = 'SUCCESS';
                }
                if ($xray->FacilityRmsNo == 'INV' && $xray->FixedDFResultDoctor !== '*') {
                    $status = 'SUCCESS';
                }
                if ($xray->CxlDateTime !== null) {
                    $status = 'Cxl';
                }

                try {
                    $oldMemo = $data['assessment'][$xray->RequestNo]['memo'];
                } catch (\Throwable $th) {
                    $oldMemo = '-';
                }

                $data['assessment'][$xray->RequestNo] = [
                    'type'      => 'xray',
                    'requestno' => $xray->RequestNo,
                    'time'      => $time,
                    'clinic'    => $xray->FacilityRmsNo . " : " . $xray->Clinic . ' ' . $xrayAppointment,
                    'doctor'    => $xray->RequestDoctor,
                    'recommend' => null,
                    'status'    => $status,
                    'memo'      => ($xray->HNXRayRequestMemoType == 2) ? $xray->RemarksMemo : $oldMemo,
                ];
            }
        }

        usort($data['assessment'], function ($item1, $item2) {
            return $item1['time'] <=> $item2['time'];
        });
        $tempVS = null;
        foreach ($data['assessment'] as $index => $dataList) {
            if ($dataList['type'] == 'vs') {
                $tempVS = [
                    'temperature' => $dataList['temperature'],
                    'pulse'       => $dataList['pulse'],
                    'respiration' => $dataList['respiration'],
                    'bpsys'       => $dataList['bpsys'],
                    'bpdias'      => $dataList['bpdias'],
                    'o2sat'       => $dataList['o2sat'],
                    'bmi'         => $dataList['bmi'],
                    'pain'        => $dataList['pain'],
                    'memo'        => $dataList['memo'],
                    'user'        => $dataList['user'],
                ];
            }
            if ($dataList['type'] == 'prescript') {
                if ($tempVS !== null) {
                    $data['assessment'][$index]['vitalsigns'] = $tempVS;
                } else {
                    $data['assessment'][$index]['vitalsigns'] = [
                        'temperature' => null,
                        'pulse'       => null,
                        'respiration' => null,
                        'bpsys'       => null,
                        'bpdias'      => null,
                        'o2sat'       => null,
                        'bmi'         => null,
                        'pain'        => null,
                        'memo'        => null,
                        'user'        => null,
                    ];
                }
            }
            // if (($index + 1) == count($data['assessment']) && $dataList['type'] == 'vs_notification') {
            //     array_splice($data['assessment'], $index, 1);
            // }
        }
        usort($data['closeVisit'], function ($item2, $item1) {
            return $item1['time'] <=> $item2['time'];
        });

        if ($showDebug) {
            dump($data);
        }

        return view('result')->with(compact('data'));
    }
}
