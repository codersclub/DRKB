---
Title: Работа через MAPI
Author: Sven Lohmann
Date: 01.01.2007
---


Работа через MAPI
=================

Вариант 1:

Source: Vingrad.ru <https://forum.vingrad.ru>

Пример с delphi.mastak.ru мне понравился (который нашел Song),
и я решил его сюда скопировать, может кому понадобится:

    unit Email;
     
    interface
     
    uses Windows, SusUtils, Classes;
     
    function SendEmail(const RecipName, RecipAddress, Subject, Attachment: string): Boolean;
    function IsOnline: Boolean;
     
    implementation
     
    uses Mapi;
     
    function SendEmail(const RecipName, RecipAddress, Subject, Attachment: string): Boolean;
    var
      MapiMessage: TMapiMessage;
      MapiFileDesc: TMapiFileDesc;
      MapiRecipDesc: TMapiRecipDesc;
      i: integer;
      s: string;
    begin
      with MapiRecipDesc do 
      begin
        ulResved:= 0;
        ulRecipClass:= MAPI_TO;
        lpszName:= PChar(RecipName);
        lpszAddress:= PChar(RecipAddress);
        ulEIDSize:= 0;
        lpEntryID:= nil;
      end;
      with MapiFileDesc do 
      begin
        ulReserved:= 0;
        flFlags:= 0;
        nPosition:= 0;
        lpszPathName:= PChar(Attachment);
        lpszFileName:= nil;
        lpFileType:= nil;
      end;
      with MapiMessage do 
      begin
        ulReserved := 0;
        lpszSubject := nil;
        lpszNoteText := PChar(Subject);
        lpszMessageType := nil;
        lpszDateReceived := nil;
        lpszConversationID := nil;
        flFlags := 0;
        lpOriginator := nil;
        nRecipCount := 1;
        lpRecips := @MapiRecipDesc;
        if length(Attachment) > 0 then 
          begin
            nFileCount:= 1;
            lpFiles := @MapiFileDesc;
          end 
        else 
          begin
            nFileCount:= 0;
            lpFiles:= nil;
          end;
      end;
      Result:= MapiSendMail(0, 0, MapiMessage,
                            MAPI_DIALOG or MAPI_LOGON_UI or MAPI_NEW_SESSION,
                            0) = SUCCESS_SUCCESS;
    end;
     
    function IsOnline: Boolean;
    var
      RASConn: TRASConn;
      dwSize,dwCount: DWORD;
    begin
      RASConns.dwSize:= SizeOf(TRASConn);
      dwSize:= SizeOf(RASConns);
      Res:=RASEnumConnectionsA(@RASConns, @dwSize, @dwCount);
      Result:= (Res = 0) and (dwCount > 0);
    end;
     
    end.


------------------------------------------------------------------------

Вариант 2:

Author: Sven Lohmann

Source: <https://forum.sources.ru>

Обычно в программах используется два способа отправки email.  
Первый - это "ShellExecute", а второй - через OLE server, как в Delphi 5.

Однако, предлагаю посмотреть, как эта задача решается посредствам MAPI.

Совместимость: Delphi 4.x (или выше)

    unit MapiControl; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs; 
     
    type 
      { Вводим новый тип события для получения Errorcode } 
      TMapiErrEvent = procedure(Sender: TObject; ErrCode: Integer) of object; 
     
      TMapiControl = class(TComponent) 
        constructor Create(AOwner: TComponent); override; 
        destructor Destroy; override; 
      private 
        { Private-объявления } 
        FSubject: string; 
        FMailtext: string; 
        FFromName: string; 
        FFromAdress: string; 
        FTOAdr: TStrings; 
        FCCAdr: TStrings; 
        FBCCAdr: TStrings; 
        FAttachedFileName: TStrings; 
        FDisplayFileName: TStrings; 
        FShowDialog: Boolean; 
        FUseAppHandle: Boolean; 
        { Error Events: } 
        FOnUserAbort: TNotifyEvent; 
        FOnMapiError: TMapiErrEvent; 
        FOnSuccess: TNotifyEvent; 
        { +> Изменения, внесённые Eugene Mayevski [mailto:Mayevski@eldos.org]} 
        procedure SetToAddr(newValue : TStrings); 
        procedure SetCCAddr(newValue : TStrings); 
        procedure SetBCCAddr(newValue : TStrings); 
        procedure SetAttachedFileName(newValue : TStrings); 
        { +< конец изменений } 
      protected 
        { Protected-объявления } 
      public 
        { Public-объявления } 
        ApplicationHandle: THandle; 
        procedure Sendmail(); 
        procedure Reset(); 
      published 
        { Published-объявления } 
        property Subject: string read FSubject write FSubject; 
        property Body: string read FMailText write FMailText; 
        property FromName: string read FFromName write FFromName; 
        property FromAdress: string read FFromAdress write FFromAdress; 
        property Recipients: TStrings read FTOAdr write SetTOAddr; 
        property CopyTo: TStrings read FCCAdr write SetCCAddr; 
        property BlindCopyTo: TStrings read FBCCAdr write SetBCCAddr; 
        property AttachedFiles: TStrings read FAttachedFileName write SetAttachedFileName; 
        property DisplayFileName: TStrings read FDisplayFileName; 
        property ShowDialog: Boolean read FShowDialog write FShowDialog; 
        property UseAppHandle: Boolean read FUseAppHandle write FUseAppHandle; 
     
        { события: } 
        property OnUserAbort: TNotifyEvent read FOnUserAbort write FOnUserAbort; 
        property OnMapiError: TMapiErrEvent read FOnMapiError write FOnMapiError; 
        property OnSuccess: TNotifyEvent read FOnSuccess write FOnSuccess; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    uses Mapi; 
     
    { регистрируем компонент: } 
    procedure Register; 
    begin 
      RegisterComponents('expectIT', [TMapiControl]); 
    end; 
     
    { TMapiControl } 
     
    constructor TMapiControl.Create(AOwner: TComponent); 
    begin 
      inherited Create(AOwner); 
      FOnUserAbort := nil; 
      FOnMapiError := nil; 
      FOnSuccess := nil; 
      FSubject := ''; 
      FMailtext := ''; 
      FFromName := ''; 
      FFromAdress := ''; 
      FTOAdr := TStringList.Create; 
      FCCAdr := TStringList.Create; 
      FBCCAdr := TStringList.Create; 
      FAttachedFileName := TStringList.Create; 
      FDisplayFileName := TStringList.Create; 
      FShowDialog := False; 
      ApplicationHandle := Application.Handle; 
    end; 
     
    { +> Изменения, внесённые Eugene Mayevski [mailto:Mayevski@eldos.org]} 
    procedure TMapiControl.SetToAddr(newValue : TStrings); 
    begin 
      FToAdr.Assign(newValue); 
    end; 
     
    procedure TMapiControl.SetCCAddr(newValue : TStrings); 
    begin 
      FCCAdr.Assign(newValue); 
    end; 
     
    procedure TMapiControl.SetBCCAddr(newValue : TStrings); 
    begin 
      FBCCAdr.Assign(newValue); 
    end; 
     
    procedure TMapiControl.SetAttachedFileName(newValue : TStrings); 
    begin 
      FAttachedFileName.Assign(newValue); 
    end; 
    { +< конец изменений } 
     
    destructor TMapiControl.Destroy; 
    begin 
      FTOAdr.Free; 
      FCCAdr.Free; 
      FBCCAdr.Free; 
      FAttachedFileName.Free; 
      FDisplayFileName.Free; 
      inherited destroy; 
    end; 
     
    { Сбрасываем все используемые поля} 
    procedure TMapiControl.Reset; 
    begin 
      FSubject := ''; 
      FMailtext := ''; 
      FFromName := ''; 
      FFromAdress := ''; 
      FTOAdr.Clear; 
      FCCAdr.Clear; 
      FBCCAdr.Clear; 
      FAttachedFileName.Clear; 
      FDisplayFileName.Clear; 
    end; 
     
    {  Эта процедура составляет и отправляет Email } 
    procedure TMapiControl.Sendmail; 
    var 
      MapiMessage: TMapiMessage; 
      MError: Cardinal; 
      Sender: TMapiRecipDesc; 
      PRecip, Recipients: PMapiRecipDesc; 
      PFiles, Attachments: PMapiFileDesc; 
      i: Integer; 
      AppHandle: THandle; 
    begin 
      { Перво-наперво сохраняем Handle приложения, if not 
        the Component might fail to send the Email or 
        your calling Program gets locked up. } 
      AppHandle := Application.Handle; 
     
      { Нам нужно зарезервировать память для всех получателей } 
      MapiMessage.nRecipCount := FTOAdr.Count + FCCAdr.Count + FBCCAdr.Count; 
      GetMem(Recipients, MapiMessage.nRecipCount * sizeof(TMapiRecipDesc)); 
     
      try 
        with MapiMessage do 
        begin 
          ulReserved := 0; 
          { Устанавливаем поле Subject: } 
          lpszSubject := PChar(Self.FSubject); 
     
          { ...  Body: } 
          lpszNoteText := PChar(FMailText); 
     
          lpszMessageType := nil; 
          lpszDateReceived := nil; 
          lpszConversationID := nil; 
          flFlags := 0; 
     
          { и отправителя: (MAPI_ORIG) } 
          Sender.ulReserved := 0; 
          Sender.ulRecipClass := MAPI_ORIG; 
          Sender.lpszName := PChar(FromName); 
          Sender.lpszAddress := PChar(FromAdress); 
          Sender.ulEIDSize := 0; 
          Sender.lpEntryID := nil; 
          lpOriginator := @Sender; 
     
          PRecip := Recipients; 
     
          { У нас много получателей письма: (MAPI_TO) 
            установим для каждого: } 
          if nRecipCount > 0 then 
          begin 
            for i := 1 to FTOAdr.Count do 
            begin 
              PRecip^.ulReserved := 0; 
              PRecip^.ulRecipClass := MAPI_TO; 
              { lpszName should carry the Name like in the 
                contacts or the adress book, I will take the 
                email adress to keep it short: } 
              PRecip^.lpszName := PChar(FTOAdr.Strings[i - 1]); 
              { Если Вы используете этот компонент совместно с Outlook97 или 2000 
                (не Express версии), то Вам прийдётся добавить 
                'SMTP:' в начало каждого (email-) адреса.
              } 
              PRecip^.lpszAddress := PChar('SMTP:' + FTOAdr.Strings[i - 1]); 
              PRecip^.ulEIDSize := 0; 
              PRecip^.lpEntryID := nil; 
              Inc(PRecip); 
            end; 
     
            { То же самое проделываем с получателями копии письма: (CC, MAPI_CC) } 
            for i := 1 to FCCAdr.Count do 
            begin 
              PRecip^.ulReserved := 0; 
              PRecip^.ulRecipClass := MAPI_CC; 
              PRecip^.lpszName := PChar(FCCAdr.Strings[i - 1]); 
              PRecip^.lpszAddress := PChar('SMTP:' + FCCAdr.Strings[i - 1]); 
              PRecip^.ulEIDSize := 0; 
              PRecip^.lpEntryID := nil; 
              Inc(PRecip); 
            end; 
     
            { ... тоже самое для Bcc: (BCC, MAPI_BCC) } 
            for i := 1 to FBCCAdr.Count do 
            begin 
              PRecip^.ulReserved := 0; 
              PRecip^.ulRecipClass := MAPI_BCC; 
              PRecip^.lpszName := PChar(FBCCAdr.Strings[i - 1]); 
              PRecip^.lpszAddress := PChar('SMTP:' + FBCCAdr.Strings[i - 1]); 
              PRecip^.ulEIDSize := 0; 
              PRecip^.lpEntryID := nil; 
              Inc(PRecip); 
            end; 
          end; 
          lpRecips := Recipients; 
     
          { Теперь обработаем прикреплённые к письму файлы: } 
     
          if FAttachedFileName.Count > 0 then 
          begin 
            nFileCount := FAttachedFileName.Count; 
            GetMem(Attachments, MapiMessage.nFileCount * sizeof(TMapiFileDesc)); 
     
            PFiles := Attachments; 
     
            { Во первых установим отображаемые на экране имена файлов (без пути): } 
            FDisplayFileName.Clear; 
            for i := 0 to FAttachedFileName.Count - 1 do 
              FDisplayFileName.Add(ExtractFileName(FAttachedFileName[i])); 
     
            if nFileCount > 0 then 
            begin 
              { Теперь составим структурку для прикреплённого файла: } 
              for i := 1 to FAttachedFileName.Count do 
              begin 
                { Устанавливаем полный путь } 
                Attachments^.lpszPathName := PChar(FAttachedFileName.Strings[i - 1]); 
                { ... и имя, отображаемое на дисплее: } 
                Attachments^.lpszFileName := PChar(FDisplayFileName.Strings[i - 1]); 
                Attachments^.ulReserved := 0; 
                Attachments^.flFlags := 0; 
                { Положение должно быть -1, за разьяснениями обращайтесь в WinApi Help. } 
                Attachments^.nPosition := Cardinal(-1); 
                Attachments^.lpFileType := nil; 
                Inc(Attachments); 
              end; 
            end; 
            lpFiles := PFiles; 
          end 
          else 
          begin 
            nFileCount := 0; 
            lpFiles := nil; 
          end; 
        end; 
     
        { Send the Mail, silent or verbose: 
          Verbose means in Express a Mail is composed and shown as setup. 
          In non-Express versions we show the Login-Dialog for a new 
          session and after we have choosen the profile to use, the 
          composed email is shown before sending 
     
          Silent does currently not work for non-Express version. We have 
          no Session, no Login Dialog so the system refuses to compose a 
          new email. In Express Versions the email is sent in the 
          background. 
        } 
        if FShowDialog then 
          MError := MapiSendMail(0, AppHandle, MapiMessage,
                                 MAPI_DIALOG or MAPI_LOGON_UI or MAPI_NEW_SESSION, 0) 
        else 
          MError := MapiSendMail(0, AppHandle, MapiMessage, 0, 0); 
     
        { Теперь обработаем сообщения об ошибках.
          В MAPI их присутствует достаточное количество.
          В этом примере я обрабатываю только два из них:
          USER_ABORT и SUCCESS, относящиеся к специальным. 
     
          Сообщения, не относящиеся к специальным: 
            MAPI_E_AMBIGUOUS_RECIPIENT, 
            MAPI_E_ATTACHMENT_NOT_FOUND, 
            MAPI_E_ATTACHMENT_OPEN_FAILURE, 
            MAPI_E_BAD_RECIPTYPE, 
            MAPI_E_FAILURE, 
            MAPI_E_INSUFFICIENT_MEMORY, 
            MAPI_E_LOGIN_FAILURE, 
            MAPI_E_TEXT_TOO_LARGE, 
            MAPI_E_TOO_MANY_FILES, 
            MAPI_E_TOO_MANY_RECIPIENTS, 
            MAPI_E_UNKNOWN_RECIPIENT: 
        } 
     
        case MError of 
          MAPI_E_USER_ABORT: 
            begin 
              if Assigned(FOnUserAbort) then 
                FOnUserAbort(Self); 
            end; 
          SUCCESS_SUCCESS: 
            begin 
              if Assigned(FOnSuccess) then 
                FOnSuccess(Self); 
            end 
        else begin 
            if Assigned(FOnMapiError) then 
              FOnMapiError(Self, MError); 
          end; 
     
        end; 
      finally 
        { В заключение освобождаем память } 
        FreeMem(Recipients, MapiMessage.nRecipCount * sizeof(TMapiRecipDesc)); 
      end; 
    end; 
     
    { 
      Вопросы и замечания присылайте Автору. 
    } 
     
    end.


------------------------------------------------------------------------

Вариант 3:

Author: Rouse\_

Source: <https://forum.sources.ru>

    uses ...,
      MAPI;
     
    // отправка письма с вложением
    // =============================================================================
    function SendEMail(Handle: THandle; Mail: TStrings): Cardinal; 
    type
      TAttachAccessArray = array [0..0] of TMapiFileDesc;
      PAttachAccessArray = ^TAttachAccessArray;
    var
      MapiMessage: TMapiMessage;
      Receip: TMapiRecipDesc;
      Attachments: PAttachAccessArray;
      AttachCount: Integer;
      i1: integer;
      FileName: string;
      dwRet: Cardinal;
      MAPI_Session: Cardinal;
      WndList: Pointer;
    begin
      Result := 0;
      dwRet := MapiLogon(Application.Handle,
        nil,
        nil,
        MAPI_NEW_SESSION + MAPI_LOGON_UI,
        0, @MAPI_Session);
     
      if (dwRet <> SUCCESS_SUCCESS) then
      begin 
        MessageBox(Handle,
          PChar('Error while trying to send email'), 
          PChar('Error'),
          MB_ICONERROR or MB_OK); 
      end
      else
      begin
        FillChar(MapiMessage, SizeOf(MapiMessage), #0);
        Attachments := nil;
        FillChar(Receip, SizeOf(Receip), #0);
     
        if Mail.Values['to'] <> '' then
        begin
          Receip.ulReserved := 0;
          Receip.ulRecipClass := MAPI_TO;
          Receip.lpszName := StrNew(PChar(Mail.Values['to']));
          Receip.lpszAddress := StrNew(PChar('SMTP:' + Mail.Values['to']));
          Receip.ulEIDSize := 0;
          MapiMessage.nRecipCount := 1;
          MapiMessage.lpRecips := @Receip;
        end;
     
        AttachCount := 0;
     
        for i1 := 0 to MaxInt do
        begin
          if Mail.Values['attachment' + IntToStr(i1)] = '' then
            break; 
          Inc(AttachCount); 
        end;
     
        if AttachCount > 0 then 
        begin 
          GetMem(Attachments, SizeOf(TMapiFileDesc) * AttachCount);
     
          for i1 := 0 to AttachCount - 1 do 
          begin
            FileName := Mail.Values['attachment' + IntToStr(i1)]; 
            Attachments[i1].ulReserved := 0; 
            Attachments[i1].flFlags := 0; 
            Attachments[i1].nPosition := ULONG($FFFFFFFF); 
            Attachments[i1].lpszPathName := StrNew(PChar(FileName)); 
            Attachments[i1].lpszFileName := 
              StrNew(PChar(ExtractFileName(FileName)));
            Attachments[i1].lpFileType := nil; 
          end; 
          MapiMessage.nFileCount := AttachCount;
          MapiMessage.lpFiles := @Attachments^;
        end;
     
        if Mail.Values['subject'] <> '' then
          MapiMessage.lpszSubject := StrNew(PChar(Mail.Values['subject']));
        if Mail.Values['body'] <> '' then
          MapiMessage.lpszNoteText := StrNew(PChar(Mail.Values['body']));
     
        WndList := DisableTaskWindows(0);
        try
        Result := MapiSendMail(MAPI_Session, Handle,
          MapiMessage, MAPI_DIALOG, 0);
        finally
          EnableTaskWindows( WndList );
        end;
     
        for i1 := 0 to AttachCount - 1 do
        begin
          StrDispose(Attachments[i1].lpszPathName);
          StrDispose(Attachments[i1].lpszFileName);
        end;
     
        if Assigned(MapiMessage.lpszSubject) then
          StrDispose(MapiMessage.lpszSubject);
        if Assigned(MapiMessage.lpszNoteText) then
          StrDispose(MapiMessage.lpszNoteText);
        if Assigned(Receip.lpszAddress) then
          StrDispose(Receip.lpszAddress);
        if Assigned(Receip.lpszName) then
          StrDispose(Receip.lpszName);
        MapiLogOff(MAPI_Session, Handle, 0, 0);
      end;
    end;

пример вызова:

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Mail: TStringList;
    begin
      Mail := TStringList.Create;
      try
        Mail.values['to'] := 'почтовый@адрес';
        Mail.values['subject'] := 'Тема письма';
        Mail.values['body'] := 'Любой текст письма';
        Mail.values['attachment0'] := 'Путь к файлу';
        sendEMail(Application.Handle, Mail);
      finally
        Mail.Free;
      end;
    end;

