---
Title: Вернуть дату без временной части
Author: Vit
Date: 01.01.2007
---


Вернуть дату без временной части
================================

    cast(floor(cast(@Date as float)) as datetime)
