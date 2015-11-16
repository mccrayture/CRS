//var tb = getField("Text1").value;
//var result = getField("Text2");
//var ctb = tb.toFixed(2);
//var fctb = ctb.toString();
//var x = ThaiBaht(fctb);
//result.value = x;

function ThaiBaht(Number) {
    for (var a = 0; a < Number.length; a++) {
        Number = Number.replace(",", ""); //ไม่ต้องการเครื่องหมายคอมมาร์
        Number = Number.replace(" ", ""); //ไม่ต้องการช่องว่าง
        Number = Number.replace("บาท", ""); //ไม่ต้องการตัวหนังสือ บาท
        Number = Number.replace("฿", ""); //ไม่ต้องการสัญลักษณ์สกุลเงินบาท
    }

    var TxtNumArr = new Array("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า", "สิบ");
    var TxtDigitArr = new Array("", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
    var BahtText = "";

    if (isNaN(Number)) {
        return "ข้อมูลนำเข้าไม่ถูกต้อง";
    } else {
        if ((Number - 0) > 9999999.9999) {
            return "ข้อมูลเกินขอบเขตที่ตั้งไว้";
        } else {
            Number = Number.split(".");
            if (Number[1].length > 0) {
                Number[1] = Number[1].substring(0, 2);
            }
            var NumberLen = Number[0].length - 0;
            for (var a = 0; a < NumberLen; a++) {
                var tmp = Number[0].substring(a, a + 1) - 0;
                if (tmp !== 0) {
                    if ((a === (NumberLen - 1)) && (tmp === 1))
                    {
                        BahtText += "เอ็ด";
                    } else if ((a === (NumberLen - 2)) && (tmp === 2)) {
                        BahtText += "ยี่";
                    } else if ((a === (NumberLen - 2)) && (tmp === 1)) {
                        BahtText += " ";
                    } else {
                        BahtText += TxtNumArr[tmp];
                    }
                    BahtText += TxtDigitArr[NumberLen - a - 1];
                }
            }

            BahtText += "บาท";

            if ((Number[1] === "0") || (Number[1] === "00")) {
                BahtText += "ถ้วน";
            } else {
                DecimalLen = Number[1].length - 0;
                for (var a = 0; a < DecimalLen; a++) {
                    var tmp = Number[1].substring(a, a + 1) - 0;
                   app.alert(tmp);
                    if (tmp !== 0) {
                        if ((a === (DecimalLen - 1)) && (tmp === 1)) {
                            BahtText += "เอ็ด";
                        } else if ((a === (DecimalLen - 2)) && (tmp === 2)) {
                            BahtText += "ยี่";
                        } else if ((a === (DecimalLen - 2)) && (tmp === 1)) {
                            BahtText += "";
                        } else {
                            BahtText += TxtNumArr[tmp];
                        }
                        BahtText += TxtDigitArr[DecimalLen - a - 1];
                    }
                }
                BahtText += "สตางค์";
            }

            return BahtText;
        }
    }
}

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}


function formatCurrency(val) {
    if (val === "" || val === null || val === "NULL")
        return val;

    //Split Decimals
    var arrs = val.toString().split(".");
    //Split data and reverse
    var revs = arrs[0].split("").reverse().join("");
    var len = revs.length;
    var tmp = "";
    for (i = 0; i < len; i++) {
        if (i > 0 && (i % 3) === 0) {
            tmp += "," + revs.charAt(i);
        } else {
            tmp += revs.charAt(i);
        }
    }

    //Split data and reverse back
    tmp = tmp.split("").reverse().join("");
    //Check Decimals
    if (arrs.length > 1 && arrs[1] !== undefined) {
        tmp += "." + arrs[1];
    }
    return tmp;
} 