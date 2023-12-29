---
Title: Учимся работать с многопоточными файлами в NT
Author: Girder
Date: 01.01.2007
---


Учимся работать с многопоточными файлами в NT
=============================================

::: {.date}
01.01.2007
:::

1\. Создание(изменение) и чтение "Опциональных потоков"

    procedure TForm1.Button1Click(Sender: TObject);
    begin
     //сохраняем то что в Memo в "многопоточный файл"
     Memo1.Lines.SaveToFile('k:\memo.txt');
     Memo2.Lines.SaveToFile('k:\memo.txt:memo2'); //опциональный поток
    end;
    procedure TForm1.Button2Click(Sender: TObject);
    begin
     //читаем в обратном порядке из "многопоточного файла"
     Memo1.Lines.LoadFromFile('k:\memo.txt:memo2'); //опциональный поток
     Memo2.Lines.LoadFromFile('k:\memo.txt');
    end;

Как видно из первого примера... что бы прочитать "Опциональный поток"
нам необходимо знать его "имя"...  . Если вам не известно енто
"имя", а очень хочется... тогда код 2 пункта предназначен для вас

2\. Определяем инфу о файле/директории - читаем инфу о потоках:

*** Не забудьте включить SE\_BACKUP\_NAME привелегию ***

    function InfoFileStreams(const FileName:String; Delete:Boolean; out RStreams:String):Boolean;
    {Входные данные:
    - FileName: Имя файла/дирректории.
    - Delete: Если Truе то... по мимо инфы еще и удаляем "Опциональные потоки" файла.
    Выходные данные:
    - True: Что-то смоглы определить :)
    - RStreams - Определенная инфа}
    const Error_Buffer_Overflow=$80000005;
    type
     _IO_STATUS_BLOCK=packed record
       Status:DWord;
       Information:DWord;
     end;
     FILE_STREAM_INFORMATION=packed record 
       NextEntry:DWord;
       NameLength:DWord;
       Size:Int64;
       AllocationSize:Int64;
       Name:WideChar;
     end;
     _FILE_INFORMATION_CLASS=(FileDirectoryInformation=1,FileFullDirectoryInformation,
                              FileBothDirectoryInformation,FileBasicInformation,
                              FileStandardInformation,FileInternalInformation,
                              FileEaInformation,FileAccessInformation,FileNameInformation,
                              FileRenameInformation,FileLinkInformation,FileNamesInformation,
                              FileDispositionInformation,FilePositionInformation,FileFullEaInformation,
                              FileModeInformation,FileAlignmentInformation,FileAllInformation,
                              FileAllocationInformation,FileEndOfFileInformation,FileAlternateNameInformation,
                              FileStreamInformation,FilePipeInformation,FilePipeLocalInformation,
                              FilePipeRemoteInformation,FileMailslotQueryInformation,FileMailslotSetInformation,
                              FileCompressionInformation,FileObjectIdInformation,FileCompletionInformation,
                              FileMoveClusterInformation,FileQuotaInformation,FileReparsePointInformation,
                              FileNetworkOpenInformation,FileAttributeTagInformation,FileTrackingInformation,
                              FileMaximumInformation);
    var NtQueryInformationFile: function (FileHandle:DWord; out IoStatusBlock: _IO_STATUS_BLOCK; FileInformation:Pointer; Length:DWord; FileInformationClass:_FILE_INFORMATION_CLASS):DWord; stdcall;
        fHandle:DWord;
        StreamIS:DWord;
        StreamInfo,tSI:^FILE_STREAM_INFORMATION;
        IoSB:_IO_STATUS_BLOCK;
        t:DWord;
        sN,sT:String;
        NextEntry,sM:Boolean;
    begin
     Result:=false;
     NtQueryInformationFile:=GetProcAddress(GetModuleHandle('ntdll.dll'),'NtQueryInformationFile');
     if Assigned(NtQueryInformationFile)=false then exit;
     fHandle:=CreateFile(PChar(FileName),GENERIC_READ,FILE_SHARE_READ or FILE_SHARE_WRITE,nil,
                         OPEN_EXISTING,FILE_FLAG_BACKUP_SEMANTICS,0);
     if fHandle<>INVALID_HANDLE_VALUE then
      begin
       StreamIS:=0;
       GetMem(StreamInfo,StreamIS);
       repeat
        FreeMem(StreamInfo,StreamIS);
        StreamIS:=StreamIS+16384;
        GetMem(StreamInfo,StreamIS);
        t:=NtQueryInformationFile(fHandle,IoSB,StreamInfo,StreamIS,FileStreamInformation);
       until (t<>Error_Buffer_Overflow);
       if (t=0)and(IoSB.Information<>0) then
        begin
         tSI:=StreamInfo;
         sN:='';
         NextEntry:=True;
         Result:=true;
         sM:=false;
         while NextEntry do
          begin
           if tSI^.NextEntry=0 then NextEntry:=false;
           sT:=Copy(PWideChar(@tSI^.Name),0,tSI^.NameLength div SizeOf(WideChar));
           if (sM=false)and(AnsiCompareText(sT,'::$DATA')=0) then
            begin
             sM:=true;
             sN:=sN+'Основной поток: '+sT+'; Размер: '+IntToStr(tSI^.Size)+' байт'+chr($D)+chr($A);
            end else
            begin
             sN:=sN+'Опциональный поток: '+sT+'; Размер: '+IntToStr(tSI^.Size)+' байт'+chr($D)+chr($A);
             if Delete then
              if DeleteFile(FileName+sT) then sN:=sN+'Удален!'+chr($D)+chr($A);
            end;
           tSI:=Pointer(DWord(tSI)+tSI^.NextEntry);
          end;
         RStreams:=sN;
        end;
       FreeMem(StreamInfo,StreamIS);
       CloseHandle(fHandle);
      end;
    end;

Ну и до кучи... пример использывания InfoFileStreams:

    const
      SE_BACKUP_NAME = 'SeBackupPrivilege';
     
    function NTSetPrivilege(sPrivilege:string;fEnabled:LongBool):boolean;
    var hToken:THandle;
        TokenPriv,PrevTokenPriv:TOKEN_PRIVILEGES;
        PrivSet:PRIVILEGE_SET;
        f:LongBool;
        i:Cardinal;
    begin
     Result:=false;
     if Win32Platform<>VER_PLATFORM_WIN32_NT then exit;
     PrivSet.PrivilegeCount:=1;
     PrivSet.Control:=0;
     PrivSet.Privilege[0].Attributes:=0;
     if LookupPrivilegeValue(nil,PChar(sPrivilege),PrivSet.Privilege[0].Luid) then
      if OpenProcessToken(GetCurrentProcess(),TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY,hToken) then
       begin
        try
         if PrivilegeCheck(hToken,PrivSet,f)and(f<>fEnabled) then
          if LookupPrivilegeValue(nil,PChar(sPrivilege),TokenPriv.Privileges[0].Luid) then
           begin
            TokenPriv.PrivilegeCount:=1;
            if fEnabled then TokenPriv.Privileges[0].Attributes:=SE_PRIVILEGE_ENABLED else
             TokenPriv.Privileges[0].Attributes:=0;
            i:=0;
            PrevTokenPriv:=TokenPriv;
            AdjustTokenPrivileges(hToken,false,TokenPriv,SizeOf(PrevTokenPriv),PrevTokenPriv,i);
            Result:=GetLastError=ERROR_SUCCESS;
           end;
        except
        end;
        CloseHandle(hToken);
       end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var s:string;
    begin
     NTSetPrivilege(SE_BACKUP_NAME,true);
     if InfoFileStreams('k:\memo.txt',false,s) then Memo1.Lines.Text:=s;
     //Удаляем опциональные потоки
     //if InfoFileStreams('k:\memo.txt',true,s) then Memo1.Lines.Text:=s;
    end;

Автор: Girder

Взято с Vingrad.ru <https://forum.vingrad.ru>
