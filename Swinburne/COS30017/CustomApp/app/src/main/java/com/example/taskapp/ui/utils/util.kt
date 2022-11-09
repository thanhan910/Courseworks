package com.example.taskapp.ui.utils


import android.content.Context
import android.graphics.drawable.Drawable
import android.view.View
import android.widget.DatePicker
import android.widget.NumberPicker
import android.widget.TimePicker
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.content.res.AppCompatResources
import com.example.taskapp.R
import java.text.SimpleDateFormat
import java.util.*


fun getCheckIcon(value: Int, context: Context): Drawable? {
    when(value) {
        1 -> return (
            AppCompatResources.getDrawable(
                context,
                R.drawable.ic_check_circle_1
            )
        )
        2 -> return (
            AppCompatResources.getDrawable(
                context,
                R.drawable.ic_cancel_1
            )
        )
        else -> return (
            AppCompatResources.getDrawable(
                context,
                R.drawable.ic_radio_button_unchecked
            )
        )
    }
}

fun getStarIcon(value: Boolean, context: Context): Drawable? {
    if(value) {
        return (
            AppCompatResources.getDrawable(
                context,
                R.drawable.ic_star_1
            )
        )
    }
    else {
        return (
            AppCompatResources.getDrawable(
                context,
                R.drawable.ic_star_0
            )
        )
    }
}

fun formatDate(date: Date, datePattern: String) : String {
    return SimpleDateFormat(datePattern, Locale.getDefault()).format(date)
}

fun formatDate(date: Date?, datePattern: String, defaultValue: String) : String {
    return if(date == null) defaultValue
    else SimpleDateFormat(datePattern, Locale.getDefault()).format(date)
}

fun showDateTimePicker(context: Context, defaultValue: Date?, onValueSelected: (Calendar) -> Unit, onRemoveValue: () -> Unit) {

    val dialogView = View.inflate(context, R.layout.fragment_date_time_picker, null)
    val datePicker = dialogView.findViewById<View>(R.id.date_picker) as DatePicker
    val timePicker = dialogView.findViewById<View>(R.id.time_picker) as TimePicker

    val alertDialog = AlertDialog.Builder(context)

    alertDialog.setView(dialogView)

    alertDialog.setPositiveButton("Select") { dialog, which ->

        val calendar: Calendar = GregorianCalendar(
            datePicker.year,
            datePicker.month,
            datePicker.dayOfMonth,
            timePicker.hour,
            timePicker.minute
        )
        onValueSelected(calendar)
        dialog.dismiss()
    }
    alertDialog.setNegativeButton("Cancel") { dialog, which -> dialog.cancel() }

    alertDialog.setNeutralButton("Remove") { dialog, which ->
        onRemoveValue()
        dialog.dismiss()
    }

    alertDialog.show()
}

fun showNumberPicker(context: Context, value: Int?, onValueSelected: (Int) -> Unit, onRemoveValue: () -> Unit) {

    val numberPicker = NumberPicker(context)
    numberPicker.minValue = 0
    numberPicker.maxValue = 1000000
    numberPicker.wrapSelectorWheel = false
    numberPicker.value = value ?: numberPicker.minValue

    val alertDialog = AlertDialog.Builder(context)

    alertDialog.setView(numberPicker)

    alertDialog.setTitle("Estimate this task")

    alertDialog.setTitle("How many days does it take to do this task?")

    alertDialog.setPositiveButton("Select") { dialog, which ->

        onValueSelected(numberPicker.value)
        dialog.dismiss()
    }
    alertDialog.setNegativeButton("Cancel") { dialog, which -> dialog.cancel() }

    alertDialog.setNeutralButton("Remove") { dialog, which ->
        onRemoveValue()
        dialog.dismiss()
    }

    alertDialog.show()
}