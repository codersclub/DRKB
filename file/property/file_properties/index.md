---
Title: Как извлечь «Сводку» свойств файла?
Author: Krid
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как извлечь «Сводку» свойств файла?
===================================

Ниже показан пример получения набора свойств файла (которые отображаются
на вкладке "Сводка" диалогового окна "Свойства:").
В файловой системе NTFS читаются свойства любого файла (если они вообще
есть, конечно). В других ФС читаются свойства только compound-файлов (они
же structured storage, т.е. файлы хранения структурированной информации,
такие как файлы MS Office, пакеты MSI, etc.), т.к. в этом случае вся
информация о свойствах находится в самих файлах (опять же, она может там и
отсутствовать). Ну и, естественно, не читаются нестандартные свойства,
т.к. они нигде не хранятся, а динамически добавляются на вкладку
соответствующим файлу COM-сервером - обработчиком вкладок свойств
(PropertySheetHandlers).

В этом примере считывается несколько свойств из набора SummaryInformation.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ComCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        ListView1: TListView;
        OpenDialog1: TOpenDialog;
        procedure Button1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses ActiveX, ComObj;
     
    function StgOpenStorageEx(const pwcsName : POleStr; grfMode : LongInt; stgfmt : DWORD;
                              grfAttrs : DWORD;  pStgOptions : Pointer; reserved2 : Pointer;
                              riid : PGUID; out stgOpen : IStorage ) : HResult; stdcall; external 'ole32.dll';
     
     
    const
    // GUID'ы для набора свойств SummaryInformation
     FMTID_SummaryInformation  : TGUID = '{F29F85E0-4FF9-1068-AB91-08002B27B3D9}';
     IID_IPropertySetStorage   : TGUID = '{0000013A-0000-0000-C000-000000000046}';
     
      STGFMT_FILE = 3;
      STGFMT_ANY = 4;
     
    type
     PPropSpecArray=^TPropSpecArray;  // массив спецификаций свойств
     TPropSpecArray=array[0..999] of TPropSpec; 
     
     PPropVariantArray=^TPropVariantArray; // массив - приемник, куда будут помещены значения нужных свойств
     TPropVariantArray=array[0..999] of TPropVariant;
     
     
    // вспомогательные ф-ции  *******
     
    function IsNTFS(AFileName : string) : boolean;
    var
     fso, drv : OleVariant;
    begin
     fso := CreateOleObject('Scripting.FileSystemObject');
     drv := fso.GetDrive(fso.GetDriveName(AFileName));
     Result:=drv.FileSystem = 'NTFS'
    end;
     
    function FileTimeToLocalSystemTime(ft:FILETIME):TSystemTime;
    var
     t:FILETIME;
    begin
     FileTimeToLocalFileTime(ft,t);
     FileTimeToSystemTime(t,result);
    end;
     
    function SysTimeToStr(ST : TSystemTime):string;
    begin
     SetLength(result,15);
     GetTimeFormat(LOCALE_USER_DEFAULT,0,@st,nil,@result[1],15);
     SetLength(result, StrLen(@result[1]));
    end;
     
    function SysDateToStr(ST : TSystemTime) : string;
    begin
     SetLength(Result, 255);
     GetDateFormat(LOCALE_USER_DEFAULT, DATE_LONGDATE, @ST, nil, @result[1], 255);
     SetLength(Result, LStrLen(@result[1]));
    end;
     
    function SysDateTimeToStr(ST:TSystemTime):string;
    begin
     result:=SysDateToStr(ST)+' '+SysTimeToStr(ST)
    end;
     
    // *******
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
     stgRoot:IStorage;
     stgPS:IPropertySetStorage;
     stgP:IPropertyStorage;
     ps:PPropSpecArray;
     pv:PPropVariantArray;
     lit:TListItem;  // значения свойств записываем в ListView
    begin
     
     if (not OpenDialog1.Execute) then exit;  // выбираем файл
     
     // Проверяем: если это не compound file и система - не NTFS, тогда выходим.
     // (для compound файлов FS не важна)
     if (StgIsStorageFile(StringToOleStr(OpenDialog1.FileName))<>S_OK) then
      if (not IsNTFS(OpenDialog1.FileName)) then
      begin
       MessageBox(Handle,'NTFS needed for non-compound files','Error',MB_ICONERROR);
       exit;
      end;
     
     
      ListView1.Clear;
     
      if (StgOpenStorageEx(StringToOleStr(OpenDialog1.FileName), STGM_READ or STGM_SHARE_DENY_WRITE,
                            STGFMT_ANY, 0, nil,  nil, 
                           @IID_IPropertySetStorage, stgRoot)<>S_OK) then  // открываем файл
      begin
       MessageBox(Handle,'Can not open file','Error',MB_ICONERROR);
       exit;
      end;
     
     stgPS:=stgRoot as IPropertySetStorage;  // ссылаемся на нужный интерфейс
    //открываем набор свойств
     if (stgPS.Open(FMTID_SummaryInformation,STGM_READ or STGM_SHARE_EXCLUSIVE,stgP)<>S_OK) then
     begin
      MessageBox(Handle,'Can not open property set','Error',MB_ICONERROR);
      exit;
     end;
     
     ps:=nil;
     pv:=nil;
     try
       GetMem(ps,SizeOf(TPropSpec));
       GetMem(pv,SizeOf(TPropVariant));
     
       ps[0].ulKind:=PRSPEC_PROPID;   // считываем свойства по их идентификатору (см. ActiveX.pas)
     
       // Прочитаем несколько свойств файла.
       // В этом примере - для наглядности - читаем по одному свойству из потока (можно за один раз прочитать и больше),
       // поэтому каждый раз значение будет лежать в pv[0].
     
       ps[0].propid:=PIDSI_TITLE;     // заголовок
       lit:=ListView1.Items.Add;
       lit.Caption:='Title';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then  // читаем свойство
       lit.SubItems.Add(pv[0].pszVal) // добавляем в ListView
       else lit.SubItems.Add('');
     
       ps[0].propid:=PIDSI_SUBJECT;   // тема
       lit:=ListView1.Items.Add;
       lit.Caption:='Subject';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then
       lit.SubItems.Add(pv[0].pszVal)
       else lit.SubItems.Add('');
     
       ps[0].propid:=PIDSI_AUTHOR;   // автор
       lit:=ListView1.Items.Add;
       lit.Caption:='Author';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then
       lit.SubItems.Add(pv[0].pszVal)
       else lit.SubItems.Add('');
     
       ps[0].propid:=PIDSI_COMMENTS; // комментарий
       lit:=ListView1.Items.Add;
       lit.Caption:='Comment';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then
       lit.SubItems.Add(pv[0].pszVal)
       else lit.SubItems.Add('');
     
       ps[0].propid:=PIDSI_REVNUMBER; // номер редакции
       lit:=ListView1.Items.Add;
       lit.Caption:='Revision';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then
       lit.SubItems.Add(pv[0].pszVal)
       else lit.SubItems.Add('');
     
       ps[0].propid:=PIDSI_APPNAME;   // приложение, создавшее пакет
       lit:=ListView1.Items.Add;
       lit.Caption:='Application';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then
       lit.SubItems.Add(pv[0].pszVal)
       else lit.SubItems.Add('');
     
       ps[0].propid:=PIDSI_CREATE_DTM;   // Дата создания
       lit:=ListView1.Items.Add;
       lit.Caption:='Creation date';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then
       lit.SubItems.Add(SysDateTimeToStr(FileTimeToLocalSystemTime(pv[0].filetime)))
       else lit.SubItems.Add('');
     
       ps[0].propid:=PIDSI_WORDCOUNT; // кол-во слов в документе
       lit:=ListView1.Items.Add;
       lit.Caption:='Word count';
       if (stgP.ReadMultiple(1, @ps[0], @pv[0])=S_OK) then
       lit.SubItems.Add(IntToStr(pv[0].lVal))
       else lit.SubItems.Add('');
     
     finally
       if assigned(ps) then FreeMem(ps);
       if assigned(pv) then FreeMem(pv);
       stgP:=nil;
       stgPS:=nil;
       stgRoot:=nil;
     end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     // добавим в список 2 столбца (лучше это делать в дизайнере)
     ListView1.ViewStyle:=vsReport;
     ListView1.Columns.Add.Caption:='Name';
     ListView1.Columns.Add.Caption:='Value';
     
     // добавим в диалог открытия несколько типов compound-файлов
     OpenDialog1.Filter:='All Files (*.*)|*.*|MS Office Documents (*.doc;*.xls;*.dot)'+
      '|*.doc; *.xls; *.dot|MSI Databases (*.msi)|*.msi';
    end;
     
    end.

