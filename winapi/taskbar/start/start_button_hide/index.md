---
Title: Как спрятать и отключить кнопку «Пуск»?
Date: 01.01.2007
---

Как спрятать и отключить кнопку «Пуск»?
=======================================

::: {.date}
01.01.2007
:::

Приведенный пример прячет и показывает кнопку \"Пуск\", а также
разрешает и запрещает ее.

    procedure TForm1.Button1Click(Sender: TObject); 
                 var 
                   Rgn : hRgn; 
                 begin 
                  {Cпрятать кнопку "Пуск"} 
                   Rgn := CreateRectRgn(0, 0, 0, 0); 
                   SetWindowRgn(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 
                                                        0, 
                                                       'Button', 
                                                        nil), 
                                                        Rgn, 
                                                        true); 
                 end; 
     
                 procedure TForm1.Button2Click(Sender: TObject); 
                 begin 
                  {Показать кнопку "Пуск"} 
                   SetWindowRgn(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 
                                                        0, 
                                                       'Button', 
                                                        nil), 
                                                        0, 
                                                        true); 
                 end; 
     
                 procedure TForm1.Button3Click(Sender: TObject); 
                 begin 
                  {Запретить кнопку "Пуск"} 
                   EnableWindow(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 
                                                        0, 
                                                        'Button', 
                                                        nil), 
                                                        false); 
                 end; 
     
                 procedure TForm1.Button4Click(Sender: TObject); 
                 begin 
                  {Разрешить кнопку "Пуск"} 
                   EnableWindow(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 
                                                        0, 
                                                        'Button', 
                                                        nil), 
                                                        true); 
                 end 

 

 
