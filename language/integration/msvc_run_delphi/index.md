---
Title: Вызов Delphi DLL из MS Visual C++
Date: 01.01.2007
---


Вызов Delphi DLL из MS Visual C++
=================================

::: {.date}
01.01.2007
:::

Во-первых, Вам необходимо объявить все экспортируемые в Delphi DLL
функции с ключевыми словами export; stdcall;

Во-вторых, файл заголовка VC++ должен объявить все функции как тип
\_\_declspec(dllexport) \_\_stdcall (применяйте двойное подчеркивание в
секции объявления прототипа функции extern "C" { ... }. (вместо этого
можно также использовать \_\_declspec(dllimport)...). Для примера:

    extern "C" {
    int  __declspec(dllexport)     __stdcall plusone(int); } 

В-третьих, в VC++ компилятор настраивается на "украшающее" имена
функций \_\_stcall, так что Ваша Delphi DLL соответственно должна
экспортировать эти функции. Для этого необходимо модифицировать файл
Delphi 2.0 .DPR для Вашего DLL, модифицируя имена всех функций,
прописанных в разделе экспорта. Для примера, если Вы экспортируете
функцию function plusone (intval : Integer), Вам необходимо включить
следующую строку в раздел экспорта .DPR-файла:

    plusone name 'plusone@4'

Число, следующее за символом @, является общей длиной в байтах всех
функциональных аргументов. Самый простой путь для обнаружения
неправильных значений - попытаться слинковать Вашу VC++ программу и
посмотреть на наличие возможной ошибки компоновщика "unresolved
external".

И, наконец, Вы можете легко создать библиотеку импорта, используя
утилиту LIB из поставки VC++. Для этого необходимо вручную (!!) создать
.DEF-файл для Вашей DLL с секцией экспорта, перечисляющей имена и/или
порядковые номера всех экспортируемых DLL функций. Формат .DEF-файла
очень прост:

    library MYLIB
    description 'Моя собственная DLL'
    exports
     
    plusone@4

Затем запускаете LIB из командной строки DOS/Win95, и в качестве
параметра подставляете имя .DEF-файла. Например, LIB /DEF:MYDLL.DEF.
Наконец, через диалог Build\|Settings\|Linker Вы информируете VC++ о
полученном .LIB-файле.

Вот пример кода:

    *******MYDLLMU.PAS 
     
     
     
    unit MyDLLMU;
     
    interface
     
    function plusone(val : Integer) : Integer; export; stdcall;
    procedure ChangeString(AString : PChar); export; stdcall;
     
    implementation
     
    uses
     
    Dialogs,
    SysUtils;
     
    function plusone(val : Integer) : Integer;
    begin
     
    Result := val + 1;
    end;
     
    procedure ChangeString(AString : PChar);
    begin
     
    if AString = 'Здравствуй' then
    StrPCopy(AString, 'Мир');
    end;
     
    end.

MYDLL.DPR

    library mydll;
     
    { Существенное замечание об управлении памятью в DLL: Если DLL экспортирует функции со
     
    строковыми параметрами или возвращающие строковые значения, модуль ShareMem надо
    указывать в разделе Uses библиотеки и проекта первым. Это касается любых строк,
    передаваемых как в DLL, так и из нее, даже если они размещаются внутри записей или
    объектов. Модуль ShareMem служит интерфейсом менеджера разделяемой памяти
    DELPHIMM.DLL, который должен разворачиваться одновременно с данной DLL. Чтобы избежать
    применения DELPHIMM.DLL, строковую информацию можно передавать с помощью параметров
    типа PChar или ShortString. }
     
    uses
     
    SysUtils,
    Classes,
    MyDLLMU in 'MyDLLMU.pas';
     
    exports
     
    plusone name 'plusone@4',
    ChangeString name 'ChangeString@4';
     
    begin
    end.

MYDLL.DEF

    ; -----------------------------------------------------------------
    ; Имя файла: MYDLL.DEF
    ; -----------------------------------------------------------------
     
    LIBRARY  MYDLL
    DESCRIPTION  'Тестовая Delphi DLL, статическая загрузка в VC++ приложение'
    EXPORTS
    plusone@4

DLLTSTADlg.H

    // DLLTSTADlg.h : заголовочный файл
    //
    #define USELIB
    #ifdef USELIB
    extern "C" {
     
    int __declspec(dllimport) __stdcall plusone(int);
    }
    #endif //USELIB
    /////////////////////////////////////////////////////////////////////////////
    // Диалог CDLLTSTADlg
     
    class CDLLTSTADlg : public CDialog
    {
    // Создание public:
     
    CDLLTSTADlg(CWnd* pParent = NULL);      // стандартный конструктор
    ~CDLLTSTADlg();
     
    // Данные диалога
     
    //{{AFX_DATA(CDLLTSTADlg)
    enum { IDD = IDD_DLLTSTA_DIALOG };
    CString m_sVal;
    CString m_sStr;
    //}}AFX_DATA
     
     
    // Перекрытая виртуальная функция, сгенерированная ClassWizard
    //{{AFX_VIRTUAL(CDLLTSTADlg)
    protected:
    virtual void DoDataExchange(CDataExchange* pDX);        // Поддержка DDX/DDV
    //}}AFX_VIRTUAL
     
    // Реализация
    protected:
     
    #ifndef USELIB
     
    HINSTANCE hMyDLL;
    FARPROC lpfnplusone;
    typedef int (*pIIFUNC)(int);
    pIIFUNC plusone;
    #endif //USELIB
     
     
    HICON m_hIcon;
     
     
    // Карта функций генераций сообщений
    //{{AFX_MSG(CDLLTSTADlg)
    virtual BOOL OnInitDialog();
    afx_msg void OnPaint();
    afx_msg HCURSOR OnQueryDragIcon();
    afx_msg void OnBtnplusone();
    afx_msg void OnBtnplusoneClick();
    afx_msg void OnBtndostringClick();
    //}}AFX_MSG
    DECLARE_MESSAGE_MAP()
    }; 

DLLTSTADlg.CPP

    // DLLTSTADlg.cpp : файл реализации
    //
     
    #include "stdafx.h"
    #include "DLLTSTA.h"
    #include "DLLTSTADlg.h"
     
    #ifdef _DEBUG
    #define new DEBUG_NEW
    #undef THIS_FILE
    static char THIS_FILE[] = __FILE__;
    #endif
     
    extern CDLLTSTAApp theApp;
     
    /////////////////////////////////////////////////////////////////////////////
    // Диалог CDLLTSTADlg
     
    CDLLTSTADlg::CDLLTSTADlg(CWnd* pParent /*=NULL*/)
     
    : CDialog(CDLLTSTADlg::IDD, pParent)
    {
     
    //{{AFX_DATA_INIT(CDLLTSTADlg)
    m_sVal = _T("1");
    m_sStr = _T("Hello");
    //}}AFX_DATA_INIT
    // Имейте в виду, что в Win32 LoadIcon не требует последующего DestroyIcon
    m_hIcon = AfxGetApp()->LoadIcon(IDR_MAINFRAME);
     
    #ifndef USELIB
     
    hMyDLL = LoadLibrary("C:\\delpwork\\MYDLL.DLL");
    if(hMyDLL == NULL)
    PostQuitMessage(1);
    lpfnplusone = GetProcAddress(HMODULE(hMyDLL), "_plusone");
    if(lpfnplusone == NULL)
    PostQuitMessage(2);
    plusone = pIIFUNC(lpfnplusone);
    #endif //USELIB
     
    }
     
    CDLLTSTADlg::~CDLLTSTADlg()
    {
    #ifndef USELIB
     
    if (hMyDLL != NULL)
    FreeLibrary(hMyDLL);
    #endif //USELIB
    }
     
    void CDLLTSTADlg::DoDataExchange(CDataExchange* pDX)
    {
     
    CDialog::DoDataExchange(pDX);
    //{{AFX_DATA_MAP(CDLLTSTADlg)
    DDX_Text(pDX, IDC_LBLINT, m_sVal);
    DDX_Text(pDX, IDC_LBLSTRING, m_sStr);
    //}}AFX_DATA_MAP
    }
     
    BEGIN_MESSAGE_MAP(CDLLTSTADlg, CDialog)
     
    //{{AFX_MSG_MAP(CDLLTSTADlg)
    ON_WM_PAINT()
    ON_WM_QUERYDRAGICON()
    ON_BN_CLICKED(IDC_BTNPLUSONE, OnBtnplusoneClick)
    ON_BN_CLICKED(IDC_BTNDOSTRING, OnBtndostringClick)
    //}}AFX_MSG_MAP
    END_MESSAGE_MAP()
     
    /////////////////////////////////////////////////////////////////////////////
    // Дескрипторы сообщений CDLLTSTADlg
     
    BOOL CDLLTSTADlg::OnInitDialog()
    {
     
    CDialog::OnInitDialog();
     
     
    // Устанавливаем иконку для данного диалога.  В случае, когда главное
    // окно программы не является диалогом, это происходит автоматически
    SetIcon(m_hIcon, TRUE);                 // Устанавливаем большую иконку
    SetIcon(m_hIcon, FALSE);                // Устанавливаем маленькую иконку
     
     
    // TODO: Здесь добавляем дополнительную инициализацию
     
     
    return TRUE;  // возвращает TRUE в случае отсутствия фокуса у диалога
    }
     
    // Если Вы добавляете в диалог кнопку минимизации, для создания иконки Вам
    //  необходим код, приведенный ниже. Для MFC-приложений используйте
    //  document/view model для автоматического создания скелета кода.
     
    void CDLLTSTADlg::OnPaint()
    {
     
    if (IsIconic())
    {
    CPaintDC dc(this); // контекст устройства для рисования
     
     
    SendMessage(WM_ICONERASEBKGND, (WPARAM) dc.GetSafeHdc(), 0);
     
     
    // Центр иконки в области клиента
    int cxIcon = GetSystemMetrics(SM_CXICON);
    int cyIcon = GetSystemMetrics(SM_CYICON);
    CRect rect;
    GetClientRect(&rect);
    int x = (rect.Width() - cxIcon + 1) / 2;
    int y = (rect.Height() - cyIcon + 1) / 2;
     
     
    // Рисование иконки
    dc.DrawIcon(x, y, m_hIcon);
    }
    else
    {
    CDialog::OnPaint();
    }
    }
     
    // Система вызывает данный код для получения курсора, выводимого если
    //  пользователь пытается перетащить свернутое окно.
    HCURSOR CDLLTSTADlg::OnQueryDragIcon()
    {
     
    return (HCURSOR) m_hIcon;
    }
     
    void CDLLTSTADlg::OnBtnplusoneClick() 
    {
     
    int iTemp;
    char sTemp[10];
     
     
     
    iTemp = atoi(m_sVal);
    iTemp = plusone(iTemp);
    m_sVal = itoa(iTemp, sTemp, 10);
    UpdateData(FALSE);
    }
     
    void CDLLTSTADlg::OnBtndostringClick()
    {
     
    UpdateData(FALSE);
    } 

Во-первых, создайте в Delphi простую DLL:

    { Начало кода DLL }
     
    library MinMax;
     
    function Min(X, Y: Integer): Integer; export;
    begin
      if X < Y then
        Min := X
      else
        Min := Y;
    end;
     
    function Max(X, Y: Integer): Integer; export;
    begin
      if X > Y then
        Max := X
      else
        Max := Y;
    end;
     
    exports
     
      Min index 1,
      Max index 2;
     
    begin
    end.
    { Конец кода DLL }
     

Затем, для вызова этих функций из вашего C кода, сделайте следующее:

В вашем .DEF-файле добавьте следующие строки:

IMPORTS

Min  =MINMAX.Min

Max  =MINMAX.Max

Объявите в вашем C-приложени прототип функций, как показано ниже:

        int FAR PASCAL Min(int x, y);
        int FAR PASCAL Min(int x, y);

Теперь из любого места вашего приложения вы можете вызвать функции Min и
Max.

Взято с <https://delphiworld.narod.ru>
