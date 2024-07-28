---
Title: Как добавить пункт меню?
Author: Pegas
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как добавить пункт меню?
========================

    procedure AddItemsM(vAction: TAction; vMenu:TMainMenu);

    var
     index: integer
     vItems :TMenuItem;
    begin
     index := vMenu.Items.IndexOf(nmWindow);
     vItems := TMenuItem.Create(vMenu);
     vItems.Action := vAction;
     vMenu.Items.Items[index].Add(vItems);
    end;

nmWindow - это Name пункта меню "Окна"

(этот код я писал для добавления открытых окон в пункт меню "Окна",
главного меню своего приложения)

