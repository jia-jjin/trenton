import "./bootstrap";

import Alpine from "alpinejs";

import AirDatepicker from "air-datepicker";
import "air-datepicker/air-datepicker.css";
import localeEn from "air-datepicker/locale/en";

import { Modal, Ripple, initTWE } from "tw-elements";

initTWE({ Modal, Ripple });

window.Alpine = Alpine;

Alpine.start();

let dpMin, dpMax;

dpMin = new AirDatepicker("#datepicker1", {
    locale: localeEn,
    dateFormat: "dd/MM/yyyy",
    minDate: new Date(),
    onSelect({ date }) {
        if (dpMax.minDate < date){
            dpMax.update({
                minDate: date,
            });
        } else {
            dpMax.update({
                minDate: new Date(),
            });
        }
    },
});

dpMax = new AirDatepicker("#datepicker2", {
    locale: localeEn,
    dateFormat: "dd/MM/yyyy",
    minDate: new Date(),
    onSelect({ date }) {
        dpMin.update({
            maxDate: date,
        });
    },
});

$(".readonly").on("keydown paste focus", function (e) {
    if (e.keyCode != 9)
        // ignore tab
        e.preventDefault();
});
