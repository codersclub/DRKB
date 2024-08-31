---
Title: Как глобально перехватить нажатие кнопки PrintScreen?
Date: 01.01.2007
---


Как глобально перехватить нажатие кнопки PrintScreen?
=====================================================

В примере для глобального перехвата нажатия клавиши print screen
регистрируется горячая клавиша (hot key).


    type 
      TForm1 = class(TForm) 
        procedure FormCreate(Sender: TObject); 
        procedure FormDestroy(Sender: TObject); 
      private 
        { Private declarations } 
        procedure WMHotKey(var Msg : TWMHotKey); message WM_HOTKEY; 
      public 
        { Public declarations } 
      end; 

    var 
      Form1: TForm1; 

    implementation 

    {$R *.DFM} 

    const id_SnapShot = 101; 

    procedure TForm1.WMHotKey (var Msg : TWMHotKey); 
    begin 
      if Msg.HotKey = id_SnapShot then 
        ShowMessage('GotIt'); 
    end; 

    procedure TForm1.FormCreate(Sender: TObject); 
    begin 
      RegisterHotKey(Form1.Handle, 
                     id_SnapShot, 
                     0, 
                     VK_SNAPSHOT); 
    end; 

    procedure TForm1.FormDestroy(Sender: TObject); 
    begin 
      UnRegisterHotKey (Form1.Handle, id_SnapShot); 
    end; 
