---
Title: Как заставить код компонента работать только в дизайне?
Date: 01.01.2007
Author: Vit
Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba
---


Как заставить код компонента работать только в дизайне?
=======================================================

    if csDesigning in ComponentState then
    begin
    ... код, работающий только в дизайне ...
    end; 



