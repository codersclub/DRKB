---
Title: Добавляем пункты в системное меню Windows
Author: MAD Rodrguez
Date: 01.01.2007
---


Добавляем пункты в системное меню Windows
=========================================

::: {.date}
01.01.2007
:::

Автор: MAD Rodrguez

Вы, наверное, задавались вопросом, почему системное меню постоянно одно
и тоже ? Пример показывает, как добавить туда такие пункты как "About"
или "Information", или что-нибудь ещё.

Нам понадобится две вещи, первая это Item ID, который может быть любым
целым числом. Второе это Описание(Caption) для нашего пункта меню. Нам
понадобится также процедура, которая будет принимать сообщения Window
для определения нажатия на наш пункт меню.

    Unit OhYeah; 
     
    Interface 
     
    Uses SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls, Forms, Dialogs, Menus; 
     
    Type 
       TForm1 = Class (TForm) 
         Procedure FormCreate (Sender : TObject); 
         Private {Private declarations} 
         Public  {Public declarations} 
         Procedure WinMsg (Var Msg : TMsg; Var Handled : Boolean); 
         Procedure DoWhatEever; 
      End; 
     
    Var Form1 : TForm1; 
     
    Implementation 
    {$R *.DFM} 
     
    Const ItemID = 99; // ID номер для пункта меню. Может быть любым 
     
    Procedure Tform1.WinMsg (Var Msg : TMsg; Var Handled : Boolean); 
    Begin 
         If Msg.Message = WM_SYSCOMMAND Then 
            If Msg.WParam = ItemID Then DoWhatEver; 
    End; 
     
    Procedure TForm1.FormCreate (Sender : TObject); 
    Begin 
         Application.OnMessage := WinMsg; 
         AppendMenu (GetSystemMenu (Form1.Handle, False), MF_SEPARATOR, 0, ''); 
         AppendMenu (GetSystemMenu (Form1.Handle, False), MF_BYPOSITION, ItemID, '&My menu'); 
         AppendMenu (GetSystemMenu (Application.Handle, False), MF_SEPARATOR, 0, ''); 
         AppendMenu (GetSystemMenu (Application.Handle, False), MF_BYPOSITION, ItemID,'&My menu minimized'); 
    End; 
     
    Procedure TForm1.DoWhatEver; 
    Begin 
      Exit;    // Вы можете добавить здесь всё, что угодно 
    End; 
     
    End

Взято из <https://forum.sources.ru>
