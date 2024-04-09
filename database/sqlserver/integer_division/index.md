---
Title: Целочисленное деление
Author: Vit
Date: 01.01.2007
---


Целочисленное деление
=====================

    Select Cast((@dividend-(@dividend % @divisor))/@divisor as bigint)
