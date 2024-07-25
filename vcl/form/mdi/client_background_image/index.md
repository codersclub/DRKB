---
Title: Как сделать родительское окно с фоновым рисунком в клиентской области?
Date: 01.01.2007
---


Как сделать родительское окно с фоновым рисунком в клиентской области?
======================================================================

Для того чтобы сделать это выполните следующие шаги:

- Создайте новый проект.

- Установите FormStyle формы в fsMDIForm

- Разместите Image на форме и загрузите в него картинку.

- Найдите { Private Declarations } в объявлении формы и добавьте
следующие строки:

        FClientInstance : TFarProc; 
        FPrevClientProc : TFarProc; 
        procedure ClientWndProc(var Message: TMessage); 

- Добавьте следующие строки в разделе implementation:

        procedure TMainForm.ClientWndProc(var Message: TMessage); 
        var 
          Dc : hDC; 
          Row : Integer; 
          Col : Integer; 
        begin 
          with Message do 
            case Msg of 
              WM_ERASEBKGND: 
              begin 
                Dc := TWMEraseBkGnd(Message).Dc; 
                for Row := 0 to ClientHeight div Image1.Picture.Height do 
                  for Col := 0 to ClientWidth div Image1.Picture.Width do 
                    BitBlt(Dc, 
                       Col * Image1.Picture.Width, 
                       Row * Image1.Picture.Height, 
                       Image1.Picture.Width, 
                       Image1.Picture.Height, 
                       Image1.Picture.Bitmap.Canvas.Handle, 
                       0, 
                       0, 
                       SRCCOPY); 
                  Result := 1; 
              end; 
              else 
                Result := CallWindowProc(FPrevClientProc, 
                                         ClientHandle, 
                                         Msg, 
                                         wParam, 
                                         lParam); 
          end; 
        end; 

- В методе формы OnCreate добавьте:

        FClientInstance := MakeObjectInstance(ClientWndProc); 
        FPrevClientProc := Pointer(GetWindowLong(ClientHandle, 
                                   GWL_WNDPROC)); 
        SetWindowLong(ClientHandle, 
                      GWL_WNDPROC, LongInt(FClientInstance));  

- Добавьте к проекту новую форму и установите ее свойство
FormStyle в fsMDIChild.

У Вас получился MDI-проект с "обоями" в клиентской области MDI формы.
