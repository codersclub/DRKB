---
Title: Создание нового пользователя NetUserAdd
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Создание нового пользователя NetUserAdd
=======================================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
      LPUSER_INFO_2 = ^USER_INFO_2;
      {$EXTERNALSYM LPUSER_INFO_2}
      PUSER_INFO_2 = ^USER_INFO_2;
      {$EXTERNALSYM PUSER_INFO_2}
      _USER_INFO_2 = record
        usri2_name: LPWSTR;
        usri2_password: LPWSTR;
        usri2_password_age: DWORD;
        usri2_priv: DWORD;
        usri2_home_dir: LPWSTR;
        usri2_comment: LPWSTR;
        usri2_flags: DWORD;
        usri2_script_path: LPWSTR;
        usri2_auth_flags: DWORD;
        usri2_full_name: LPWSTR;
        usri2_usr_comment: LPWSTR;
        usri2_parms: LPWSTR;
        usri2_workstations: LPWSTR;
        usri2_last_logon: DWORD;
        usri2_last_logoff: DWORD;
        usri2_acct_expires: DWORD;
        usri2_max_storage: DWORD;
        usri2_units_per_week: DWORD;
        usri2_logon_hours: PBYTE;
        usri2_bad_pw_count: DWORD;
        usri2_num_logons: DWORD;
        usri2_logon_server: LPWSTR;
        usri2_country_code: DWORD;
        usri2_code_page: DWORD;
      end;
      {$EXTERNALSYM _USER_INFO_2}
      USER_INFO_2 = _USER_INFO_2;
      {$EXTERNALSYM USER_INFO_2}
      TUserInfo2 = USER_INFO_2;
      PUserInfo2 = puser_info_2;  
     
      function NetUserAdd(ServerName: LPCWSTR;
                          Level: DWORD;
                          Buff: PByte;
                          var Parm_Err: DWORD): DWORD;
               stdcall; external 'netapi32.dll';
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    const
      NERR_Success = 0;
      USER_PRIV_USER  = 1;
      UF_SCRIPT = $0001;
      UF_DONT_EXPIRE_PASSWD = $10000;
    var
      UserInfo: TUserInfo2;
      Parm_Err: DWORD;
    begin
      ZeroMemory(@UserInfo, SizeOf(TUserInfo2));
      UserInfo.usri2_name := 'TestUser';
      UserInfo.usri2_password := '123';
      UserInfo.usri2_priv := USER_PRIV_USER;
      UserInfo.usri2_flags := UF_SCRIPT or UF_DONT_EXPIRE_PASSWD;
      if NetUserAdd(nil, 2, @UserInfo, Parm_Err) <> NERR_Success then
        RaiseLastOSError
      else
        ShowMessage('Пользователь TestUser с паролем 123 успешно добавлен.');
    end;
     
    end.

