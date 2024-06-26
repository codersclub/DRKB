---
Title: Демонстрация обратного вызова BDE
Date: 01.01.2007
---


Демонстрация обратного вызова BDE
=================================

Вариант 1.

Существует обратный вызов (callback) BDE, который вы можете использовать
для получения уведомлений об изменении таблиц Paradox. Тем не менее от
вас все же потребуется использование таймера. Функция обратного вызова
инициируется при вызове функций, осуществляющих доступ к таблице. Ниже
приведен код, демонстрирующий технику работы с описанным выше обратным
вызовом:

TCMAIN.PAS:

    unit tcmain;
     
    { Демонстрация cbTableChange }
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      DB, DBTables, ExtCtrls, DBCtrls, Grids, DBGrids, BDE, StdCtrls;
     
    const
     
      WM_UPDATETABLE = WM_USER + 1;
     
    type
     
      TForm1 = class(TForm)
        Table1: TTable;
        DataSource1: TDataSource;
        DBGrid1: TDBGrid;
        DBNavigator1: TDBNavigator;
        Timer1: TTimer;
        Button1: TButton;
        procedure Table1AfterOpen(DataSet: TDataSet);
        procedure FormCreate(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
      private
        FChgCnt: Integer;
        FCB: TBDECallback;
        function TableChangeCallBack(CBInfo: Pointer): CBRType;
        procedure UpdateTableData(var Msg: TMessage); message WM_UPDATETABLE;
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    // Это функция, вызываемая функцией обратного вызова.
     
    function TForm1.TableChangeCallBack(CBInfo: Pointer): CBRType;
    begin
     
      Inc(FChgCnt);
      Caption := IntToStr(FChgCnt);
      MessageBeep(0);
    // Здесь мы не можем вызвать Table1.Refresh, делаем это позже.
      PostMessage(Handle, WM_UPDATETABLE, 0, 0);
    end;
     
    // Данная функция вызывается в ответ на PostMessage (см. выше).
     
    procedure TForm1.UpdateTableData(var Msg: TMessage);
    begin
     
    // Не пытайтесь вызвать обновление, если мы в "середине" редактирования.
      if (Table1.State = dsBrowse) then
        Table1.Refresh;
    end;
     
    procedure TForm1.Table1AfterOpen(DataSet: TDataSet);
    begin
     
    // Установка обратного вызова.
      FCB := TBDECallback.Create(Self, Table1.Handle, cbTableChanged,
        nil, 0, TableChangeCallBack);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     
      Table1.DatabaseName := ExtractFilePath(ParamStr(0));
      Table1.Open;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
     
      SeqNo: Longint;
    begin
     
    // События таймера просто осуществляют вызов DbiGetSeqNo для получения доступа к таблице.
    // В противном случае мы не хотим делать обратный вызов, пока что-то делаем
    // (типа прокрутки) для получения доступа к данным. DbiGetSeqNo вызывается в случае,
    // если таблица не активна.
      if Table1.State <> dsInActive then
        DbiGetSeqNo(Table1.Handle, SeqNo);
    end;
     
    end.

TCMAIN.TXT:

    object Form1: TForm1
     
      Left = 270
        Top = 230
        Width = 361
        Height = 251
        Caption = 'Form1'
        PixelsPerInch = 96
        OnCreate = FormCreate
        TextHeight = 13
        object DBGrid1: TDBGrid
        Left = 0
          Top = 83
          Width = 353
          Height = 141
          Align = alBottom
          DataSource = DataSource1
          TabOrder = 0
      end
      object DBNavigator1: TDBNavigator
        Left = 96
          Top = 4
          Width = 240
          Height = 25
          DataSource = DataSource1
          TabOrder = 1
      end
      object Button1: TButton
        Left = 132
          Top = 36
          Width = 75
          Height = 25
          Caption = 'Button1'
          TabOrder = 2
          OnClick = Timer1Timer
      end
      object Table1: TTable
        AfterOpen = Table1AfterOpen
          DatabaseName = 'DBDEMOS'
          TableName = 'VENDORS.DB'
          Left = 16
          Top = 8
      end
      object DataSource1: TDataSource
        DataSet = Table1
          Left = 52
          Top = 8
      end
      object Timer1: TTimer
        OnTimer = Timer1Timer
          Left = 80
          Top = 28
      end
    end

Author: Mark Edington

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba

------------------------------------------------------------------------

Вариант 2.

Данный совет показывает как в Delphi 2.01 можно использовать функцию BDE
DbiCallBack для получения значения линейки прогресса при длительных
пакетных операциях, связанных с движением данных.

Дополнительная документация, описывающая вызовы функций BDE, находится в
файле BDE32.HLP (расположенном в каталоге, где установлен 32-битный
IDAPI).

При создании функций обратного вызова BDE, BDE будет осуществлять
"обратный вызов" функций вашего приложения, позволяя тем самым
извещать ваше приложение о происходящих событиях, а в некоторых случаях
передавать информацию обратно BDE.

BDE определяет несколько возвращаемых типов, которые могут быть
установлены для обратного вызова:

- состояние больших пакетных операций.
- запросы для передачи информации вызывающему оператору.

Данный совет подробно описывает обратный вызов типа cbGENPROGRESS,
позволяющий изменять полоску прогресса в соответствии с состоянием
операции.

Чтобы это сделать, необходимо сперва вызвать функцию DbiGetCallBack(),
возвращающую дескриптор обратного вызова, который мог быть уже
установлен (с этими параметрами), и сохранить информацию в структуре
данных. Затем установить свой обратный вызов, заменяя им любой
установленный до этого.

При установке вашего обратного вызова вам понадобится передавать BDE
указатель на структуру данных, содержащую информацию о предыдущем
установленном обратном вызове, после чего, при выполнении вашей функции
обратного вызова, вы можете воспользоваться оригинальным обратным
вызовом (если он установлен).

BDE каждый раз возвращает вашему приложению сообщение, содержащее
количество обработанных записей, или же процентное соотношение
обработанных записей, также передаваемое в виде целого числа. Ваш код
должен учитывать эту ситуацию. Если процентное поле в структуре
обратного вызова больше чем -1, можно сделать вывод что передан процент
и можно сразу обновить линейку прогресса. Если же это поле меньше нуля,
обратный вызов получил текстовое сообщение, помещенное в поле szTMsg и
содержащее количество обработанных записей. В этом случае вам
понадобится осуществить грамматический разбор текстового сообщения,
преобразовать остальные строки в целое, затем вычислить текущий процент
обработанных записей, и только после этого изменить линейку прогресса.

Наконец, после осуществления операции с данными, вам необходимо
"отрегистрировать" ваш обратный вызов, и вновь установить предыдущую
функцию обратного вызова (если она существует).

Для следующего примера необходимо создать форму и расположить на ней две
таблицы, компонент ProgressBar и кнопку.

    unit Testbc1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, Grids, DBGrids, DB, DBTables, ComCtrls;
     
    type
      TForm1 = class(TForm)
        Table1: TTable;
        BatchMove1: TBatchMove;
        Table2: TTable;
        Button1: TButton;
        ProgressBar1: TProgressBar;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses Bde; {Здесь расположены Dbi Types и Procs}
     
    {$R *.DFM}
     
    {тип структуры данных для сохранения информации о предыдущем обратном вызове}
    type
      TDbiCbInfo = record
        ecbType: CBType;
        iClientData: longint;
        DataBuffLn: word;
        DataBuff: pCBPROGRESSDesc;
        DbiCbFn: pointer;
      end;
    type
      PDbiCbInfo = ^TDbiCbInfo;
     
      {Наша функция обратного вызова}
     
    function DbiCbFn(ecbType: CBType;
      iClientData: Longint;
      CbInfo: pointer): CBRType stdcall;
    var
      s: string;
    begin
      {Проверяем, является ли тип обратного вызова тем, который мы ожидаем}
      if ecbType = cbGENPROGRESS then
      begin
        {если iPercentDone меньше нуля, извлекаем число}
        {обработанных записей из параметра szMsg}
        if pCBPROGRESSDesc(cbInfo).iPercentDone < 0 then
        begin
          s := pCBPROGRESSDesc(cbInfo).szMsg;
          Delete(s, 1, Pos(': ', s) + 1);
          {Вычислям процент выполненного и изменяем линейку прогресса}
          Form1.ProgressBar1.Position :=
            Round((StrToInt(s) / Form1.Table1.RecordCount) * 100);
        end
        else
        begin
          {Устанавливаем линейку прогресса}
          Form1.ProgressBar1.Position :=
            pCBPROGRESSDesc(cbInfo).iPercentDone;
        end;
      end;
      {существовал ли предыдущий зарегистрированный обратный вызов?}
      {если так - осуществляем вызов и возвращаемся}
      if PDbiCbInfo(iClientData)^.DbiCbFn <> nil then
        DbiCbFn :=
          pfDBICallBack(PDbiCbInfo(iClientData)^.DbiCbFn)
          (ecbType,
          PDbiCbInfo(iClientData)^.iClientData,
          cbInfo)
      else
        DbiCbFn := cbrCONTINUE;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      CbDataBuff: CBPROGRESSDesc; {Структура DBi}
      {структура данных должна хранить информацию о предыдущем обратном вызове}
      OldDbiCbInfo: TDbiCbInfo;
    begin
      {Убедимся в том, что перемещаемая таблица открыта}
      Table1.Open;
      {Убедимся в том, что таблица-приемник закрыта}
      Table2.Close;
      {получаем информацию о любом установленном обратном вызове}
      DbiGetCallBack(Table2.Handle,
        cbGENPROGRESS,
        @OldDbiCbInfo.iClientData,
        @OldDbiCbInfo.DataBuffLn,
        @OldDbiCbInfo.DataBuff,
        pfDBICallBack(OldDbiCbInfo.DbiCbFn));
      {регистрируем наш обратный вызов}
      DbiRegisterCallBack(Table2.Handle,
        cbGENPROGRESS,
        longint(@OldDbiCbInfo),
        SizeOf(cbDataBuff),
        @cbDataBuff,
        @DbiCbFn);
     
      Form1.ProgressBar1.Position := 0;
      BatchMove1.Execute;
     
      {если предыдущий обратный вызов существовал - вновь устанавливаем его,}
      {в противном случае "отрегистрируем" наш обратный вызов}
      if OldDbiCbInfo.DbiCbFn <> nil then
        DbiRegisterCallBack(Table2.Handle,
          cbGENPROGRESS,
          OldDbiCbInfo.iClientData,
          OldDbiCbInfo.DataBuffLn,
          OldDbiCbInfo.DataBuff,
          OldDbiCbInfo.DbiCbFn)
      else
        DbiRegisterCallBack(Table2.Handle,
          cbGENPROGRESS,
          longint(@OldDbiCbInfo),
          SizeOf(cbDataBuff),
          @cbDataBuff,
          nil);
     
      {Показываем наш успех!}
      Table2.Open;
     
    end;
     
    end.

Source: <https://delphiworld.narod.ru>
