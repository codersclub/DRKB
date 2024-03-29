---
Title: Как можно работать с DDE под Delphi, используя вызовы API?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как можно работать с DDE под Delphi, используя вызовы API?
==========================================================

Кстати, достаточно легко: следующий пример демонстрирует как можно
научить общаться клиентскую программу с программой-сервером. Обе
программы полностью созданы на Delphi. В итоге мы имеет 2 проекта, 3
формы и 3 модуля. Для работы с DDE-запросами данный пример использует
методы DDE ML API.

Сервер должен начать свою работу перед тем, как клиент будет загружен.
Данный пример демонстрирует 3 способа взаимодействия между клиентом и
сервером:

Клиент может "пропихивать" (POKE) данные на сервер.

Сервер может автоматически передавать данные клиенту, после чего клиент
обновляет свой вид на основе результатов, полученных от сервера.

Данные сервера изменяются, после чего клиент делает запрос серверу для
получения новых данных и обновляет свой вид.

    { *** НАЧАЛО КОДА DDEMLCLI.DPR *** }
    program Ddemlcli;
     
    uses
     
      Forms,
      Ddemlclu in 'DDEMLCLU.PAS' {Form1};
     
    {$R *.RES}
     
    begin
     
      Application.CreateForm(TForm1, Form1);
      Application.Run;
    end.
    { ***  КОНЕЦ КОДА DDEMLCLI.DPR *** }

    { *** НАЧАЛО КОДА DDEMLCLU.DFM *** }
    object Form1: TForm1
     
      Left = 197
        Top = 95
        Width = 413
        Height = 287
        HorzScrollBar.Visible = False
        VertScrollBar.Visible = False
        Caption = 'Демонстрация DDEML, Клиентское приложение'
        Font.Color = clWindowText
        Font.Height = -13
        Font.Name = 'System'
        Font.Style = []
        Menu = MainMenu1
        PixelsPerInch = 96
        OnCreate = FormCreate
        OnDestroy = FormDestroy
        OnShow = FormShow
        TextHeight = 16
        object PaintBox1: TPaintBox
        Left = 0
          Top = 0
          Width = 405
          Height = 241
          Align = alClient
          Color = clWhite
          ParentColor = False
          OnPaint = PaintBox1Paint
      end
      object MainMenu1: TMainMenu
        Top = 208
          object File1: TMenuItem
          Caption = '&Файл'
            object exit1: TMenuItem
            Caption = 'В&ыход'
              OnClick = exit1Click
          end
        end
        object DDE1: TMenuItem
          Caption = '&DDE'
            object RequestUpdate1: TMenuItem
            Caption = '&Запрос на обновление'
              OnClick = RequestUpdate1Click
          end
          object AdviseofChanges1: TMenuItem
            Caption = '&Сообщение об изменениях'
              OnClick = AdviseofChanges1Click
          end
          object N1: TMenuItem
            Caption = '-'
          end
          object PokeSomeData: TMenuItem
            Caption = '&Пропихивание данных'
              OnClick = PokeSomeDataClick
          end
        end
      end
    end
    { ***  КОНЕЦ КОДА DDEMLCLU.DFM *** }

    { *** НАЧАЛО КОДА DDEMLCLU.PAS *** }
    {***************************************************}
    {                                                   }
    {   Delphi 1.0 DDEML Демонстрационная программа     }
    {   Copyright (c) 1996 by Borland International     }
    {                                                   }
    {***************************************************}
     
    { Это демонстрационное приложение, демонстрирующее использование
    DDEML API в клиентском приложении. Оно использует серверное
    приложение DataEntry, которое является частью данной демонстрации,
    и служит для ввода данных и отображения их на графической панели.
     
    Сначала вы должны запустить приложение-сервер (в DDEMLSRV.PAS),
    а затем стартовать клиента. Если сервер не запущен, клиент при
    попытке соединения потерпит неудачу.
     
    Интерфейс сервера определен списком имен (Service, Topic и Items)
    в отдельном модуле с именем DataEntry (DATAENTR.TPU). Сервер
    делает Items доступными в формате cf_Text; они преобразовываются
    и хранятся локально как целые. }
     
    unit Ddemlclu;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, VBXCtrl, ExtCtrls, DDEML, Menus, StdCtrls;
     
    const
     
      NumValues = 3;
     
    type
     
      { Структура данных, представленная в примере }
      TDataSample = array[1..NumValues] of Integer;
      TDataString = array[0..20] of Char; { Размер элемента как текста }
     
      { Главная форма }
      TForm1 = class(TForm)
        MainMenu1: TMainMenu;
        File1: TMenuItem;
        exit1: TMenuItem;
        DDE1: TMenuItem;
        RequestUpdate1: TMenuItem;
        AdviseofChanges1: TMenuItem;
        PokeSomeData: TMenuItem;
        N1: TMenuItem;
        PaintBox1: TPaintBox;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure RequestUpdate1Click(Sender: TObject);
        procedure FormShow(Sender: TObject);
        procedure AdviseofChanges1Click(Sender: TObject);
        procedure PokeSomeDataClick(Sender: TObject);
     
        procedure Request(HConversation: HConv);
        procedure exit1Click(Sender: TObject);
        procedure PaintBox1Paint(Sender: TObject);
     
      private
        { Private declarations }
      public
        Inst: Longint;
        CallBackPtr: ^TCallback;
        ServiceHSz: HSz;
        TopicHSz: HSz;
        ItemHSz: array[1..NumValues] of HSz;
        ConvHdl: HConv;
     
        DataSample: TDataSample;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    const
     
      DataEntryName: PChar = 'DataEntry';
      DataTopicName: PChar = 'SampledData';
      DataItemNames: array[1..NumValues] of pChar = ('DataItem1',
        'DataItem2',
        'DataItem3');
    {$R *.DFM}
     
      { Локальная функция: Процедура обратного вызова для DDEML }
     
    function CallbackProc(CallType, Fmt: Word; Conv: HConv; hsz1, hsz2: HSZ;
     
      Data: HDDEData; Data1, Data2: Longint): HDDEData; export;
    begin
     
      CallbackProc := 0; { В противном случае смотрите доказательство }
     
      case CallType of
        xtyp_Register:
          begin
            { Ничего ... Просто возвращаем 0 }
          end;
        xtyp_Unregister:
          begin
            { Ничего ... Просто возвращаем 0 }
          end;
        xtyp_xAct_Complete:
          begin
            { Ничего ... Просто возвращаем 0 }
          end;
        xtyp_Request, Xtyp_AdvData:
          begin
            Form1.Request(Conv);
            CallbackProc := dde_FAck;
          end;
        xtyp_Disconnect:
          begin
            ShowMessage('Соединение разорвано!');
            Form1.Close;
          end;
      end;
    end;
     
    { Посылка DDE запроса для получения cf_Text данных с сервера.
    Запрашиваем данные для всех полей DataSample, и обновляем
    окно для их отображения. Данные с сервера получаем синхронно,
    используя DdeClientTransaction.}
     
    procedure TForm1.Request(HConversation: HConv);
    var
     
      hDdeTemp: HDDEData;
      DataStr: TDataString;
      Err, I: Integer;
    begin
     
      if HConversation <> 0 then
      begin
        for I := Low(ItemHSz) to High(ItemHSz) do
        begin
          hDdeTemp := DdeClientTransaction(nil, 0, HConversation, ItemHSz[I],
            cf_Text, xtyp_Request, 0, nil);
          if hDdeTemp <> 0 then
          begin
            DdeGetData(hDdeTemp, @DataStr, SizeOf(DataStr), 0);
            Val(DataStr, DataSample[I], Err);
          end; { if }
        end; { for }
        Paintbox1.Refresh; { Обновляем экран }
      end; { if }
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
     
      I: Integer;
      { Создаем экземпляр окна DDE-клиента. Создаем окно, используя
      унаследованный конструктор, инициализируем экземпляр данных.}
    begin
     
      Inst := 0; { Должен быть нулем для первого вызова DdeInitialize }
      CallBackPtr := nil; { MakeProcInstance вызывается из SetupWindow    }
      ConvHdl := 0;
      ServiceHSz := 0;
      TopicHSz := 0;
      for I := Low(DataSample) to High(DataSample) do
      begin
        ItemHSz[I] := 0;
        DataSample[I] := 0;
      end;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    { Уничтожаем экземпляр клиентского окна. Освобождаем дескрипторы
    DDE строк, и освобождаем экземпляр функции обратного вызова,
    если она существует. Также, для завершения диалога, вызовите
    DdeUninitialize. Затем, для завершения работы, вызовите
    разрушителя предка. }
    var
      I: Integer;
    begin
     
      if ServiceHSz <> 0 then
        DdeFreeStringHandle(Inst, ServiceHSz);
      if TopicHSz <> 0 then
        DdeFreeStringHandle(Inst, TopicHSz);
      for I := Low(ItemHSz) to High(ItemHSz) do
        if ItemHSz[I] <> 0 then
          DdeFreeStringHandle(Inst, ItemHSz[I]);
     
      if Inst <> 0 then
        DdeUninitialize(Inst); { Игнорируем возвращаемое значение }
     
      if CallBackPtr <> nil then
        FreeProcInstance(CallBackPtr);
    end;
     
    procedure TForm1.RequestUpdate1Click(Sender: TObject);
    begin
      { Генерируем запрос DDE в ответ на выбор пункта меню DDE | Request.}
     
      Request(ConvHdl);
    end;
     
    procedure TForm1.FormShow(Sender: TObject);
    { Завершаем инициализацию окна сервера DDE. Выполняем те действия,
    которые требует правильное окно. Инициализируем использование DDEML. }
    var
     
      I: Integer;
      InitOK: Boolean;
    begin
     
      CallBackPtr := MakeProcInstance(@CallBackProc, HInstance);
     
      { Инициализируем DDE и устанавливаем функцию обратного вызова.
      Если сервер отсутствует, вызов терпит неудачу. }
     
      if CallBackPtr <> nil then
      begin
        if DdeInitialize(Inst, TCallback(CallBackPtr), AppCmd_ClientOnly,
          0) = dmlErr_No_Error then
        begin
          ServiceHSz := DdeCreateStringHandle(Inst, DataEntryName, cp_WinAnsi);
          TopicHSz := DdeCreateStringHandle(Inst, DataTopicName, cp_WinAnsi);
          InitOK := True;
          {     for I := Low(DataItemNames) to High(DataItemNames) do begin }
     
          for I := 1 to NumValues do
          begin
            ItemHSz[I] := DdeCreateStringHandle(Inst, DataItemNames[I],
              cp_WinAnsi);
            InitOK := InitOK and (ItemHSz[I] <> 0);
          end;
     
          if (ServiceHSz <> 0) and (TopicHSz <> 0) and InitOK then
          begin
            ConvHdl := DdeConnect(Inst, ServiceHSz, TopicHSz, nil);
            if ConvHdl = 0 then
            begin
              ShowMessage('Не могу инициализировать диалог!');
              Close;
            end
          end
          else
          begin
            ShowMessage('Не могу создать строки!');
            Close;
          end
        end
        else
        begin
          ShowMessage('Не могу осуществить инициализацию!');
          Close;
        end;
      end;
    end;
     
    procedure TForm1.AdviseofChanges1Click(Sender: TObject);
    { Переключаемся на режим DDE Advise с помощью пункта меню DDE |
    Advise (уведомление). При выборе этого пункта меню все три
    элемента переключаются на уведомление. }
    var
     
      I: Integer;
      TransType: Word;
      TempResult: Longint;
    begin
     
      with TMenuITem(Sender) do
      begin
        Checked := not Checked;
        if Checked then
          TransType := (xtyp_AdvStart or xtypf_AckReq)
        else
          TransType := xtyp_AdvStop;
      end; { with }
     
      for I := Low(ItemHSz) to High(ItemHSz) do
        if DdeClientTransaction(nil, 0, ConvHdl, ItemHSz[I], cf_Text,
          TransType, 1000, @TempResult) = 0 then
          ShowMessage('Не могу выполнить транзакцию-уведомление');
     
      if TransType and xtyp_AdvStart <> 0 then
        Request(ConvHdl);
    end;
     
    procedure TForm1.PokeSomeDataClick(Sender: TObject);
    { Генерируем DDE-Poke транзакцию в ответ на выбор пункта
    меню DDE | Poke. Запрашиваем значение у пользователя,
    которое будем "проталкивать" в DataItem1 в качестве
    иллюстрации Poke-функции.}
    var
     
      DataStr: pChar;
      S: string;
    begin
     
      S := '0';
      if InputQuery('PokeData', 'Задайте проталкиваемую (Poke) величину', S) then
      begin
        S := S + #0;
        DataStr := @S[1];
        DdeClientTransaction(DataStr, StrLen(DataStr) + 1, ConvHdl,
          ItemHSz[1], cf_Text, xtyp_Poke, 1000, nil);
        Request(ConvHdl);
      end;
    end;
     
    procedure TForm1.exit1Click(Sender: TObject);
    begin
     
      close;
    end;
     
    procedure TForm1.PaintBox1Paint(Sender: TObject);
    { После запроса обновляем окно. Рисуем график объема текущих продаж.}
    const
     
      LMarg = 30; { Левое поле графика }
    var
     
      I,
        Norm: Integer;
      Wd: Integer;
      Step: Integer;
     
      ARect: TRect;
     
    begin
     
      Norm := 0;
      for I := Low(DataSample) to High(DataSample) do
      begin
        if abs(DataSample[I]) > Norm then
          Norm := abs(DataSample[I]);
      end; { for }
     
      if Norm = 0 then
        Norm := 1; { В случае если у нас все нули }
     
      with TPaintBox(Sender).Canvas do
      begin
        { Рисуем задний фон }
        Brush.color := clWhite;
        FillRect(ClipRect);
     
        { Рисуем ось }
        MoveTo(0, ClipRect.Bottom div 2);
        LineTo(ClipRect.Right, ClipRect.Bottom div 2);
     
        MoveTo(LMarg, 0);
        LineTo(LMarg, ClipRect.Bottom);
     
        { Печатаем текст левого поля }
        TextOut(0, 0, IntToStr(Norm));
        TextOut(0, ClipRect.Bottom div 2, '0');
        TextOut(0, ClipRect.Bottom + Font.Height, IntToStr(-Norm));
     
        TextOut(0, ClipRect.Bottom div 2, '0');
        TextOut(0, ClipRect.Bottom div 2, '0');
        TextOut(0, ClipRect.Bottom div 2, '0');
        { Печатаем текст оси X }
     
        { Теперь рисуем бары на основе нормализованного значения.
        Вычисляем ширину баров (чтобы они все вместились в окне)
        и ширину пробела между ними, который приблизительно равен
        20% от их ширины. }
     
        {        SelectObject(PaintDC, CreateSolidBrush(RGB(255, 0, 0)));
     
        SetBkMode(PaintDC, Transparent);
        }
     
        ARect := ClipRect;
        Wd := (ARect.Right - LMarg) div NumValues;
        Step := Wd div 5;
        Wd := Wd - Step;
        with ARect do
        begin
          Left := LMarg + (Step div 2);
          Top := ClipRect.Bottom div 2;
        end; { with }
     
        { Выводим бары и текст для оси X }
        for i := Low(DataSample) to High(DataSample) do
        begin
          with ARect do
          begin
            Right := Left + Wd;
            Bottom := Top - Round((Top - 5) * (DataSample[I] / Norm));
          end; { with }
          { Заполняем бар }
          Brush.color := clFuchsia;
          FillRect(ARect);
          { Выводим текст для горизонтальной оси }
          Brush.color := clWhite;
          TextOut(ARect.Left, ClipRect.Bottom div 2 - Font.Height,
            StrPas(DataItemNames[i]));
          with ARect do
            Left := Left + Wd + Step;
        end; { for }
      end; { with }
    end;
    end. { ***  КОНЕЦ КОДА DDEMLCLU.PAS *** }

    { *** НАЧАЛО КОДА DDEMLSVR.DPR *** }
    program Ddemlsvr;
     
    uses
     
      Forms,
      Ddesvru in 'DDESVRU.PAS' {Form1},
      Ddedlg in '\DELPHI\BIN\DDEDLG.PAS' {DataEntry};
     
    {$R *.RES}
     
    begin
     
      Application.CreateForm(TForm1, Form1);
      Application.CreateForm(TDataEntry, DataEntry);
      Application.Run;
    end.
    { ***  КОНЕЦ КОДА DDEMLSVR.DPR *** }

    { *** НАЧАЛО КОДА DDESVRU.DFM *** }
    object Form1: TForm1
     
      Left = 712
        Top = 98
        Width = 307
        Height = 162
        Caption = 'Демонстрация DDEML, Серверное приложение'
        Color = clWhite
        Font.Color = clWindowText
        Font.Height = -13
        Font.Name = 'System'
        Font.Style = []
        Menu = MainMenu1
        PixelsPerInch = 96
        OnCreate = FormCreate
        OnDestroy = FormDestroy
        OnShow = FormShow
        TextHeight = 16
        object Label1: TLabel
        Left = 0
          Top = 0
          Width = 99
          Height = 16
          Caption = 'Текущие значения:'
      end
      object Label2: TLabel
        Left = 16
          Top = 24
          Width = 74
          Height = 16
          Caption = 'Data Item1:'
      end
      object Label3: TLabel
        Left = 16
          Top = 40
          Width = 74
          Height = 16
          Caption = 'Data Item2:'
      end
      object Label4: TLabel
        Left = 16
          Top = 56
          Width = 74
          Height = 16
          Caption = 'Data Item3:'
      end
      object Label5: TLabel
        Left = 0
          Top = 88
          Width = 265
          Height = 16
          Caption = 'Выбор данных | Ввод данных для изменения значений.'
      end
      object Label6: TLabel
        Left = 96
          Top = 24
          Width = 8
          Height = 16
          Caption = '0'
      end
      object Label7: TLabel
        Left = 96
          Top = 40
          Width = 8
          Height = 16
          Caption = '0'
      end
      object Label8: TLabel
        Left = 96
          Top = 56
          Width = 8
          Height = 16
          Caption = '0'
      end
      object MainMenu1: TMainMenu
        Left = 352
          Top = 24
          object File1: TMenuItem
          Caption = '&Файл'
            object Exit1: TMenuItem
            Caption = '&Выход'
              OnClick = Exit1Click
          end
        end
        object Data1: TMenuItem
          Caption = '&Данные'
            object EnterData1: TMenuItem
            Caption = '&Ввод данных'
              OnClick = EnterData1Click
          end
          object Clear1: TMenuItem
            Caption = '&Очистить'
              OnClick = Clear1Click
          end
        end
      end
    end
    { ***  КОНЕЦ КОДА DDESVRU.DFM *** }

    { *** НАЧАЛО КОДА DDESVRU.PAS *** }
    {***************************************************}
    {                                                   }
    {   Delphi 1.0 DDEML Демонстрационная программа     }
    {   Copyright (c) 1996 by Borland International     }
    {                                                   }
    {***************************************************}
     
    { Данный демонстрационный пример использует библиотеку DDEML
    на стороне сервера кооперативного приложения. Данный сервер
    является простым приложением для ввода данных и позволяет
    оператору осуществлять ввод трех элементов данных, которые
    становятся доступными через DDE "заинтересованным" клиентам.
     
    Данный сервер предоставляет свои услуги (сервисы) для данных
    со следующими именами:
     
    Service: 'DataEntry'
    Topic  : 'SampledData'
    Items  : 'DataItem1', 'DataItem2', 'DataItem3'
     
    В-принципе, в качестве сервисов могли бы быть определены
    и другие темы. Полезными темами, на наш взгляд, могут быть
    исторические даты, информация о сэмплах и пр..
     
    Вы должны запустить этот сервер ПЕРЕД тем как запустите
    клиента (DDEMLCLI.PAS), в противном случае клиент не
    сможет установить связь.
     
    Интерфейс для этого сервера определен как список имен
    (Service, Topic и Items) в отдельном модуле с именем
    DataEntry (DATAENTR.TPU). Сервер делает Items доступными
    в формате cf_Text; они преобразовываются и хранятся у
    клиента локально как целые. }
     
    unit Ddesvru;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, Menus,
     
      DDEML, { DDE APi }
      ShellApi;
     
    const
     
      NumValues = 3;
      DataItemNames: array[1..NumValues] of PChar = ('DataItem1',
        'DataItem2',
        'DataItem3');
    type
     
      TDataString = array[0..20] of Char; { Размер элемента как текста }
      TDataSample = array[1..NumValues] of Integer;
     
      {type
      { Структура данных, составляющих образец }
      {  TDataSample = array [1..NumValues] of Integer;
      {  TDataString = array [0..20] of Char;     { Размер элемента как текста }
     
    const
     
      DataEntryName: PChar = 'DataEntry';
      DataTopicName: PChar = 'SampledData';
     
    type
     
      TForm1 = class(TForm)
        MainMenu1: TMainMenu;
        File1: TMenuItem;
        Exit1: TMenuItem;
        Data1: TMenuItem;
        EnterData1: TMenuItem;
        Clear1: TMenuItem;
        Label1: TLabel;
        Label2: TLabel;
        Label3: TLabel;
        Label4: TLabel;
        Label5: TLabel;
        Label6: TLabel;
        Label7: TLabel;
        Label8: TLabel;
        procedure Exit1Click(Sender: TObject);
     
        function MatchTopicAndService(Topic, Service: HSz): Boolean;
        function MatchTopicAndItem(Topic, Item: HSz): Integer;
        function WildConnect(Topic, Service: HSz; ClipFmt: Word): HDDEData;
        function AcceptPoke(Item: HSz; ClipFmt: Word;
          Data: HDDEData): Boolean;
        function DataRequested(TransType: Word; ItemNum: Integer;
          ClipFmt: Word): HDDEData;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure FormShow(Sender: TObject);
        procedure EnterData1Click(Sender: TObject);
        procedure Clear1Click(Sender: TObject);
     
      private
        Inst: Longint;
        CallBack: TCallback;
        ServiceHSz: HSz;
        TopicHSz: HSz;
        ItemHSz: array[1..NumValues] of HSz;
        ConvHdl: HConv;
        Advising: array[1..NumValues] of Boolean;
     
        DataSample: TDataSample;
     
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
    uses DDEDlg; { Форма DataEntry }
     
    {$R *.DFM}
     
    procedure TForm1.Exit1Click(Sender: TObject);
    begin
     
      Close;
    end;
    { Глобальная инициализация }
     
    const
     
      DemoTitle: PChar = 'DDEML демо, серверное приложение';
     
      MaxAdvisories = 100;
      NumAdvLoops: Integer = 0;
     
      { Локальная функция: Процедура обратного вызова для DDEML }
     
      { Данная функция обратного вызова реагирует на все транзакции,
      генерируемые DDEML. Объект "target Window" (окно-цель)
      берется из глобально хранимых, и для реагирования на данную
      транзакцию, тип которой указан в параметре CallType,
      используются подходящие методы этих объектов.}
     
    function CallbackProc(CallType, Fmt: Word; Conv: HConv; HSz1, HSz2: HSZ;
     
      Data: HDDEData; Data1, Data2: Longint): HDDEData; export;
    var
     
      ItemNum: Integer;
    begin
     
      CallbackProc := 0; { В противном случае смотрите доказательство }
     
      case CallType of
     
        xtyp_WildConnect:
          CallbackProc := Form1.WildConnect(HSz1, HSz2, Fmt);
     
        xtyp_Connect:
          if Conv = 0 then
          begin
            if Form1.MatchTopicAndService(HSz1, HSz2) then
              CallbackProc := 1; { Связь! }
          end;
        { После подтверждения установки соединения записываем
        дескриптор связи как родительское окно.}
     
        xtyp_Connect_Confirm:
          Form1.ConvHdl := Conv;
     
        { Клиент запрашивает данные, делает прямой запрос или
        отвечает на уведомление. Возвращаем текущее состояние данных.}
     
        xtyp_AdvReq, xtyp_Request:
          begin
            ItemNum := Form1.MatchTopicAndItem(HSz1, HSz2);
            if ItemNum > 0 then
              CallbackProc := Form1.DataRequested(CallType, ItemNum, Fmt);
          end;
     
        { Отвечаем на Poke-запрос ... данная демонстрация допускает
        только Pokes для DataItem1. Для подтверждения получения
        запроса возвращаем dde_FAck, в противном случае 0.}
     
        xtyp_Poke:
          begin
            if Form1.AcceptPoke(HSz2, Fmt, Data) then
              CallbackProc := dde_FAck;
          end;
     
        { Клиент сделал запрос для старта цикла-уведомления.
        Имейте в виду, что мы организуем "горячий" цикл.
        Устанавливаем флаг Advising для указания открытого
        цикла, который будет проверять данные на предмет
        их изменения.}
     
        xtyp_AdvStart:
          begin
            ItemNum := Form1.MatchTopicAndItem(HSz1, HSz2);
            if ItemNum > 0 then
            begin
              if NumAdvLoops < MaxAdvisories then
              begin { Произвольное число }
                Inc(NumAdvLoops);
                Form1.Advising[ItemNum] := True;
                CallbackProc := 1;
              end;
            end;
          end;
     
        { Клиент сделал запрос на прерывание цикла-уведомления.}
     
        xtyp_AdvStop:
          begin
            ItemNum := Form1.MatchTopicAndItem(HSz1, HSz2);
            if ItemNum > 0 then
            begin
              if NumAdvLoops > 0 then
              begin
                Dec(NumAdvLoops);
                if NumAdvLoops = 0 then
                  Form1.Advising[ItemNum] := False;
                CallbackProc := 1;
              end;
            end;
          end;
      end; { Case CallType }
     
    end;
     
    { Возращает True, если данные Topic и Service поддерживаются
    этим приложением. В противном случае возвращается False.}
     
    function TForm1.MatchTopicAndService(Topic, Service: HSz): Boolean;
    begin
     
      Result := False;
      if DdeCmpStringHandles(TopicHSz, Topic) = 0 then
        if DdeCmpStringHandles(ServiceHSz, Service) = 0 then
          Result := True;
    end;
     
    { Определяем, один ли Topic и Item поддерживается этим
    приложением. Возвращаем номер заданного элемента (Item Number)
    (в пределах 1..NumValues), если он обнаружен, и ноль в
    противном случае.}
     
    function TForm1.MatchTopicAndItem(Topic, Item: HSz): Integer;
    var
     
      I: Integer;
    begin
     
      Result := 0;
      if DdeCmpStringHandles(TopicHSz, Topic) = 0 then
        for I := 1 to NumValues do
          if DdeCmpStringHandles(ItemHSz[I], Item) = 0 then
            Result := I;
    end;
     
    { Отвечаем на запрос wildcard-соединения (дословно -
    дикая карта, шаблон). Такие запросы возникают всякий раз,
    когда клиент пытается подключиться к серверу с сервисом
    или именем топика, установленного в 0. Если сервер
    обнаруживает использование такого рода шаблона, он
    возвращает дескриптор массива THSZPair, содержащего
    найденные по шаблону Service и Topic.}
     
    function TForm1.WildConnect(Topic, Service: HSz; ClipFmt: Word): HDDEData;
    var
     
      TempPairs: array[0..1] of THSZPair;
      Matched: Boolean;
    begin
     
      TempPairs[0].hszSvc := ServiceHSz;
      TempPairs[0].hszTopic := TopicHSz;
      TempPairs[1].hszSvc := 0; { 0-завершает список }
      TempPairs[1].hszTopic := 0;
     
      Matched := False;
     
      if (Topic = 0) and (Service = 0) then
        Matched := True { Шаблон обработан, элементов не найдено }
      else if (Topic = 0) and (DdeCmpStringHandles(Service, ServiceHSz) = 0) then
        Matched := True
      else if (DdeCmpStringHandles(Topic, TopicHSz) = 0) and (Service = 0) then
        Matched := True;
     
      if Matched then
        WildConnect := DdeCreateDataHandle(Inst, @TempPairs, SizeOf(TempPairs),
          0, 0, ClipFmt, 0)
      else
        WildConnect := 0;
    end;
     
    { Принимаем и проталкиваем данные по просьбе клиента.
    Для демонстрации этого способа используем только
    значение DataItem1, изменяемое Poke.}
     
    function TForm1.AcceptPoke(Item: HSz; ClipFmt: Word;
     
      Data: HDDEData): Boolean;
    var
     
      DataStr: TDataString;
      Err: Integer;
      TempSample: Integer;
    begin
     
      if (DdeCmpStringHandles(Item, ItemHSz[1]) = 0) and
        (ClipFmt = cf_Text) then
      begin
        DdeGetData(Data, @DataStr, SizeOf(DataStr), 0);
        Val(DataStr, TempSample, Err);
     
        if IntToStr(TempSample) <> Label6.Caption then
        begin
          Label6.Caption := IntToStr(TempSample);
          DataSample[1] := TempSample;
          if Advising[1] then
            DdePostAdvise(Inst, TopicHSz, ItemHSz[1]);
        end;
        AcceptPoke := True;
      end
      else
        AcceptPoke := False;
    end;
     
    { Возвращаем данные, запрашиваемые значениями TransType
    и ClipFmt. Такое может произойти в ответ на просьбу
    xtyp_Request или xtyp_AdvReq. Параметр ItemNum указывает
    на поддерживаемый (в диапазоне 1..NumValues) и требуемый
    элемент (обратите внимание на то, что данный метод
    подразумевает, что вызывающий оператор уже установил
    достоверность и ID требуемого пункта с помощью
    MatchTopicAndItem). Соответствующие данные из переменной
    экземпляра DataSample преобразуются в текст и возвращаются
    клиенту.}
     
    function TForm1.DataRequested(TransType: Word; ItemNum: Integer;
     
      ClipFmt: Word): HDDEData;
    var
      ItemStr: TDataString; { Определено в DataEntry.TPU }
     
    begin
     
      if ClipFmt = cf_Text then
      begin
        Str(DataSample[ItemNum], ItemStr);
        DataRequested := DdeCreateDataHandle(Inst, @ItemStr,
          StrLen(ItemStr) + 1, 0, ItemHSz[ItemNum], ClipFmt, 0);
      end
      else
        DataRequested := 0;
    end;
     
    { Создаем экземпляр окна DDE сервера. Вызываем унаследованный
    конструктор, затем устанавливаем эти объекты родителями
    экземпляров данных. }
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      I: Integer;
    begin
     
      Inst := 0; { Должен быть нулем для первого вызова DdeInitialize }
      @CallBack := nil; { MakeProcInstance вызывается из SetupWindow         }
     
      for I := 1 to NumValues do
      begin
        DataSample[I] := 0;
        Advising[I] := False;
      end; { for }
     
    end;
     
    { Разрушаем экземпляр окна DDE сервера. Проверяем, был ли
    создан экземпляр процедуры обратного вызова, если он существует.
    Также, для завершения диалога, вызовите DdeUninitialize.
    Затем, для завершения работы, вызовите разрушителя предка.}
     
    procedure TForm1.FormDestroy(Sender: TObject);
    var
     
      I: Integer;
    begin
     
      if ServiceHSz <> 0 then
        DdeFreeStringHandle(Inst, ServiceHSz);
      if TopicHSz <> 0 then
        DdeFreeStringHandle(Inst, TopicHSz);
      for I := 1 to NumValues do
        if ItemHSz[I] <> 0 then
          DdeFreeStringHandle(Inst, ItemHSz[I]);
     
      if Inst <> 0 then
        DdeUninitialize(Inst); { Игнорируем возвращаемое значение }
     
      if @CallBack <> nil then
        FreeProcInstance(@CallBack);
    end;
     
    procedure TForm1.FormShow(Sender: TObject);
    var
     
      I: Integer;
      { Завершаем инициализацию окна DDE сервера. Процедура инициализации
      использует DDEML для регистрации сервисов, предусмотренных данным
      приложением. Помните о том, что реальные имена, использованные в
      регистрах, определены в отдельном модуле (DataEntry), поэтому они
      могут быть использованы и клиентом. }
     
    begin
     
      @CallBack := MakeProcInstance(@CallBackProc, HInstance);
     
      if DdeInitialize(Inst, CallBack, 0, 0) = dmlErr_No_Error then
      begin
        ServiceHSz := DdeCreateStringHandle(Inst, DataEntryName, cp_WinAnsi);
        TopicHSz := DdeCreateStringHandle(Inst, DataTopicName, cp_WinAnsi);
        for I := 1 to NumValues do
          ItemHSz[I] := DdeCreateStringHandle(Inst, DataItemNames[I],
            cp_WinAnsi);
     
        if DdeNameService(Inst, ServiceHSz, 0, dns_Register) = 0 then
          ShowMessage('Ошибка в процессе регистрации.');
      end;
    end;
     
    procedure TForm1.EnterData1Click(Sender: TObject);
    { Активизируем диалог ввода данных и обновляем
    хранимые данные по окончании ввода.}
    var
     
      I: Integer;
     
    begin
     
      if DataEntry.ShowModal = mrOk then
      begin
        with DataEntry do
        begin
          Label6.Caption := S1;
          Label7.Caption := S2;
          Label8.Caption := S3;
          DataSample[1] := StrToInt(S1);
          DataSample[2] := StrToInt(S2);
          DataSample[3] := StrToInt(S3);
        end; { with }
     
        for I := 1 to NumValues do
          if Advising[I] then
            DdePostAdvise(Inst, TopicHSz, ItemHSz[I]);
      end; { if }
    end;
     
    procedure TForm1.Clear1Click(Sender: TObject);
    { Очищаем текущую дату. }
    var
     
      I: Integer;
     
    begin
     
      for I := 1 to NumValues do
      begin
        DataSample[I] := 0;
        if Advising[I] then
          DdePostAdvise(Inst, TopicHSz, ItemHSz[I]);
      end;
     
      Label6.Caption := '0';
      Label7.Caption := '0';
      Label8.Caption := '0';
    end;
     
    end.
    { ***  КОНЕЦ КОДА DDESVRU.PAS *** }

    { *** НАЧАЛО КОДА DDEDLG.DFM *** }
    object DataEntry: TDataEntry
     
      Left = 488
        Top = 132
        ActiveControl = OKBtn
        BorderStyle = bsDialog
        Caption = 'Ввод данных'
        ClientHeight = 264
        ClientWidth = 199
        Font.Color = clBlack
        Font.Height = -11
        Font.Name = 'MS Sans Serif'
        Font.Style = [fsBold]
        PixelsPerInch = 96
        Position = poScreenCenter
        OnShow = FormShow
        TextHeight = 13
        object Bevel1: TBevel
        Left = 8
          Top = 8
          Width = 177
          Height = 201
          Shape = bsFrame
          IsControl = True
      end
      object OKBtn: TBitBtn
        Left = 16
          Top = 216
          Width = 69
          Height = 39
          Caption = '&OK'
          ModalResult = 1
          TabOrder = 3
          OnClick = OKBtnClick
          Glyph.Data = {
        BE060000424DBE06000000000000360400002800000024000000120000000100
        0800000000008802000000000000000000000000000000000000000000000000
        80000080000000808000800000008000800080800000C0C0C000C0DCC000F0CA
        A600000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        0000000000000000000000000000000000000000000000000000000000000000
        000000000000000000000000000000000000F0FBFF00A4A0A000808080000000
        FF0000FF000000FFFF00FF000000FF00FF00FFFF0000FFFFFF00030303030303
        0303030303030303030303030303030303030303030303030303030303030303
        03030303030303030303030303030303030303030303FF030303030303030303
        03030303030303040403030303030303030303030303030303F8F8FF03030303
        03030303030303030303040202040303030303030303030303030303F80303F8
        FF030303030303030303030303040202020204030303030303030303030303F8
        03030303F8FF0303030303030303030304020202020202040303030303030303
        0303F8030303030303F8FF030303030303030304020202FA0202020204030303
        0303030303F8FF0303F8FF030303F8FF03030303030303020202FA03FA020202
        040303030303030303F8FF03F803F8FF0303F8FF03030303030303FA02FA0303
        03FA0202020403030303030303F8FFF8030303F8FF0303F8FF03030303030303
        FA0303030303FA0202020403030303030303F80303030303F8FF0303F8FF0303
        0303030303030303030303FA0202020403030303030303030303030303F8FF03
        03F8FF03030303030303030303030303FA020202040303030303030303030303
        0303F8FF0303F8FF03030303030303030303030303FA02020204030303030303
        03030303030303F8FF0303F8FF03030303030303030303030303FA0202020403
        030303030303030303030303F8FF0303F8FF03030303030303030303030303FA
        0202040303030303030303030303030303F8FF03F8FF03030303030303030303
        03030303FA0202030303030303030303030303030303F8FFF803030303030303
        030303030303030303FA0303030303030303030303030303030303F803030303
        0303030303030303030303030303030303030303030303030303030303030303
        0303}
        Margin = 2
          NumGlyphs = 2
          Spacing = -1
          IsControl = True
      end
      object CancelBtn: TBitBtn
        Left = 108
          Top = 216
          Width = 69
          Height = 39
          Caption = '&Отмена'
          TabOrder = 4
          Kind = bkCancel
          Margin = 2
          Spacing = -1
          IsControl = True
      end
      object Panel2: TPanel
        Left = 16
          Top = 88
          Width = 153
          Height = 49
          BevelInner = bvLowered
          BevelOuter = bvNone
          TabOrder = 1
          object Label1: TLabel
          Left = 24
            Top = 8
            Width = 5
            Height = 13
        end
        object Label2: TLabel
          Left = 8
            Top = 8
            Width = 48
            Height = 13
            Caption = 'Значение 2:'
        end
        object Edit2: TEdit
          Left = 8
            Top = 24
            Width = 121
            Height = 20
            MaxLength = 10
            TabOrder = 0
            Text = '0'
        end
      end
      object Panel1: TPanel
        Left = 16
          Top = 16
          Width = 153
          Height = 49
          BevelInner = bvLowered
          BevelOuter = bvNone
          TabOrder = 0
          object Label4: TLabel
          Left = 8
            Top = 8
            Width = 48
            Height = 13
            Caption = 'Значение 1:'
        end
        object Edit1: TEdit
          Left = 8
            Top = 24
            Width = 121
            Height = 20
            MaxLength = 10
            TabOrder = 0
            Text = '0'
        end
      end
      object Panel3: TPanel
        Left = 16
          Top = 144
          Width = 153
          Height = 49
          BevelInner = bvLowered
          BevelOuter = bvNone
          TabOrder = 2
          object Label6: TLabel
          Left = 8
            Top = 8
            Width = 48
            Height = 13
            Caption = 'Значение 3:'
        end
        object Edit3: TEdit
          Left = 8
            Top = 24
            Width = 121
            Height = 20
            MaxLength = 10
            TabOrder = 0
            Text = '0'
        end
      end
    end
    { ***   КОНЕЦ КОДА DDEDLG.DFM *** }

    { *** НАЧАЛО КОДА DDEDLG.PAS *** }
    {***************************************************}
    {                                                   }
    {   Delphi 1.0 DDEML Демонстрационная программа     }
    {   Copyright (c) 1996 by Borland International     }
    {                                                   }
    {***************************************************}
     
    { Данный модуль определяет интерфейс сервера DataEntry DDE
     
    (DDEMLSRV.PAS). Здесь определены имена Service, Topic,
    и Item, поддерживаемые сервером, и также определена
    структура данных, которая может использоваться
    клиентом для локального хранения "показательных" данных.
     
    Сервер Data Entry Server делает свои "показательные"
    данные доступными в текстовом виде (cf_Text)
    сформированными в виде трех различных топика (Topics).
    Клиент может их преобразовывать в целое для
    использования со структурой данных, которая здесь определена.
    }
    unit Ddedlg;
     
    interface
     
    uses WinTypes, WinProcs, Classes, Graphics, Forms, Controls, Buttons,
     
      StdCtrls, Mask, ExtCtrls;
     
    type
     
      TDataEntry = class(TForm)
        OKBtn: TBitBtn;
        CancelBtn: TBitBtn;
        Bevel1: TBevel;
        Panel2: TPanel;
        Label1: TLabel;
        Label2: TLabel;
        Panel1: TPanel;
        Label4: TLabel;
        Panel3: TPanel;
        Label6: TLabel;
        Edit1: TEdit;
        Edit2: TEdit;
        Edit3: TEdit;
        procedure OKBtnClick(Sender: TObject);
        procedure FormShow(Sender: TObject);
      private
        { Private declarations }
      public
        S1, S2, S3: string;
        { Public declarations }
      end;
     
    var
     
      DataEntry: TDataEntry;
     
    implementation
     
    {$R *.DFM}
     
    procedure TDataEntry.OKBtnClick(Sender: TObject);
    begin
     
      S1 := Edit1.Text;
      S2 := Edit2.Text;
      S3 := Edit3.Text;
    end;
     
    procedure TDataEntry.FormShow(Sender: TObject);
    begin
     
      Edit1.Text := '0';
      Edit2.Text := '0';
      Edit3.Text := '0';
      Edit1.SetFocus;
    end;
     
    end.
    { ***  КОНЕЦ КОДА DDEDLG.PAS *** }


