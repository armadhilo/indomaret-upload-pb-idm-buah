<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseConnection;
use App\Helper\ApiFormatter;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalKirimBuahController extends Controller
{

    public function __construct(Request $request)
    {
        DatabaseConnection::setConnection(session('KODECABANG'), "PRODUCTION");
    }

    public function index(){

        $this->CreateTabelBuah();
        $this->LoadToko();

        return view("master_timbangan");
    }

    private function loadToko(){
        // sb.AppendLine("SELECT tko_kodeomi, ")
        // sb.AppendLine("       tko_namaomi ")
        // sb.AppendLine("  FROM tbmaster_tokoigr ")
        // sb.AppendLine(" WHERE COALESCE(tko_tgltutup, CURRENT_DATE+1) > CURRENT_DATE ")
        // sb.AppendLine(" ORDER BY tko_kodeomi ")
    }

    public function datatables(){
        // sb.AppendLine("SELECT toko, ")
        // sb.AppendLine("       CASE WHEN minggu = 0 THEN 'N' ELSE 'Y' END minggu, ")
        // sb.AppendLine("       CASE WHEN senin = 0  THEN 'N' ELSE 'Y' END senin, ")
        // sb.AppendLine("       CASE WHEN selasa = 0 THEN 'N' ELSE 'Y' END selasa, ")
        // sb.AppendLine("       CASE WHEN rabu =  0  THEN 'N' ELSE 'Y' END rabu, ")
        // sb.AppendLine("       CASE WHEN kamis = 0  THEN 'N' ELSE 'Y' END kamis, ")
        // sb.AppendLine("       CASE WHEN jumat = 0  THEN 'N' ELSE 'Y' END jumat, ")
        // sb.AppendLine("       CASE WHEN sabtu = 0  THEN 'N' ELSE 'Y' END sabtu ")
        // sb.AppendLine("FROM ( ")
        // sb.AppendLine("  SELECT jkb_kodetoko toko, ")
        // sb.AppendLine("         SUM(CASE WHEN jkb_hari = 'MINGGU' THEN 1 ELSE 0 END) minggu, ")
        // sb.AppendLine("         SUM(CASE WHEN jkb_hari = 'SENIN'  THEN 1 ELSE 0 END) senin, ")
        // sb.AppendLine("         SUM(CASE WHEN jkb_hari = 'SELASA' THEN 1 ELSE 0 END) selasa, ")
        // sb.AppendLine("         SUM(CASE WHEN jkb_hari = 'RABU'   THEN 1 ELSE 0 END) rabu, ")
        // sb.AppendLine("         SUM(CASE WHEN jkb_hari = 'KAMIS'  THEN 1 ELSE 0 END) kamis, ")
        // sb.AppendLine("         SUM(CASE WHEN jkb_hari = 'JUMAT'  THEN 1 ELSE 0 END) jumat, ")
        // sb.AppendLine("         SUM(CASE WHEN jkb_hari = 'SABTU'  THEN 1 ELSE 0 END) sabtu ")
        // sb.AppendLine("  FROM jadwal_kirim_buah  ")
        // sb.AppendLine("  GROUP BY jkb_kodetoko ")
        // sb.AppendLine(") AS A ORDER BY toko ")
    }

    //? jika data di table dipilih maka checkbox hari akan mengikuti yang ada table
    public function loadDetailHari(){
        // IsiDT("SELECT jkb_hari FROM jadwal_kirim_buah WHERE jkb_kodetoko = '" & toko & "'", dt, "GET HARI")
    }

    //!BAGIAN A
    //? ketika terpilih maka akan mengisi nama toko berdasarkan data yang dipilih di table
    public function getNamaToko(){
        //? tempelkan nama toko dari datatables
    }

    //! BAGIAN B
    public function actionSave(){
        //* jika kode toko kosong -> Pilih Dulu Kode Toko!!", MsgBoxStyle.Information, ProgName)
        //* Simpan Jadwal Kirim Buah Toko " & Trim(cboKodeToko.Text) & " ??",

        //! GUNAKAN ACTION simpanJadwalKirim
        // If Not simpanJadwalKirim(Trim(cboKodeToko.Text), Trim(txtNamaToko.Text), "MINGGU", cbMinggu.Checked) Then MsgBox("Toko " & cboKodeToko.Text & " Gagal Disimpan !!") : Exit Sub
        // If Not simpanJadwalKirim(Trim(cboKodeToko.Text), Trim(txtNamaToko.Text), "SENIN", cbSenin.Checked) Then MsgBox("Toko " & cboKodeToko.Text & " Gagal Disimpan !!") : Exit Sub
        // If Not simpanJadwalKirim(Trim(cboKodeToko.Text), Trim(txtNamaToko.Text), "SELASA", cbSelasa.Checked) Then MsgBox("Toko " & cboKodeToko.Text & " Gagal Disimpan !!") : Exit Sub
        // If Not simpanJadwalKirim(Trim(cboKodeToko.Text), Trim(txtNamaToko.Text), "RABU", cbRabu.Checked) Then MsgBox("Toko " & cboKodeToko.Text & " Gagal Disimpan !!") : Exit Sub
        // If Not simpanJadwalKirim(Trim(cboKodeToko.Text), Trim(txtNamaToko.Text), "KAMIS", cbKamis.Checked) Then MsgBox("Toko " & cboKodeToko.Text & " Gagal Disimpan !!") : Exit Sub
        // If Not simpanJadwalKirim(Trim(cboKodeToko.Text), Trim(txtNamaToko.Text), "JUMAT", cbJumat.Checked) Then MsgBox("Toko " & cboKodeToko.Text & " Gagal Disimpan !!") : Exit Sub
        // If Not simpanJadwalKirim(Trim(cboKodeToko.Text), Trim(txtNamaToko.Text), "SABTU", cbSabtu.Checked) Then MsgBox("Toko " & cboKodeToko.Text & " Gagal Disimpan !!") : Exit Sub
    }

    //! BAGIAN C
    public function delete(){
        //* Anda Yakin Untuk Menghapus Toko " & dgvJadwal.CurrentRow.Cells(1).Value & " ??

        //! DELETE FROM JADWAL_KIRIM_BUAH
        // sb.AppendLine("DELETE FROM JADWAL_KIRIM_BUAH ")
        // sb.AppendLine(" WHERE JKB_KodeToko = '" & dgvJadwal.CurrentRow.Cells(0).Value & "' ")

        //* Toko " & dgvJadwal.CurrentRow.Cells(1).Value & " Sudah Berhasil Dihapus!!
    }

    private function simpanJadwalKirim($toko, $nama_toko, $hari, $flag_kirim){
        //! CEK HARI ADA
        // sb.AppendLine("Select COALESCE(count(JKB_KodeToko),0) ")
        // sb.AppendLine("  From JADWAL_KIRIM_BUAH ")
        // sb.AppendLine(" Where JKB_KodeToko = '" & toko & "' ")
        // sb.AppendLine("   And JKB_Hari = '" & hari & "' ")

        // If flagKirim Then
        //     'JIKA KIRIM DAN BELUM DIINSERT DATA
        //     If jum = 0 Then
        //         sb = New StringBuilder
        //         sb.AppendLine("INSERT INTO jadwal_kirim_buah ")
        //         sb.AppendLine("( ")
        //         sb.AppendLine("  jkb_hari, ")
        //         sb.AppendLine("  jkb_kodetoko, ")
        //         sb.AppendLine("  jkb_namatoko, ")
        //         sb.AppendLine("  jkb_create_by, ")
        //         sb.AppendLine("  jkb_create_dt ")
        //         sb.AppendLine(") ")
        //         sb.AppendLine("VALUES ")
        //         sb.AppendLine("( ")
        //         sb.AppendLine("  '" & hari & "', ")
        //         sb.AppendLine("  '" & toko & "', ")
        //         sb.AppendLine("  '" & namaToko & "', ")
        //         sb.AppendLine("  '" & UserID & "', ")
        //         sb.AppendLine("  CURRENT_TIMESTAMP ")
        //         sb.AppendLine(") ")
        //         ExecQRY(sb.ToString, "INSERT INTO JADWAL_KIRIM_BUAH")
        //     End If
        // Else
        //     'JIKA TIDAK KIRIM DAN SUDAH ADA DATA
        //     If jum > 0 Then
        //         sb = New StringBuilder
        //         sb.AppendLine("DELETE FROM jadwal_kirim_buah ")
        //         sb.AppendLine(" WHERE jkb_kodetoko = '" & toko & "' ")
        //         sb.AppendLine("   AND jkb_hari = '" & hari & "' ")
        //         ExecQRY(sb.ToString, "DELETE FROM JADWAL_KIRIM_BUAH")
        //     End If
        // End If
    }
}
