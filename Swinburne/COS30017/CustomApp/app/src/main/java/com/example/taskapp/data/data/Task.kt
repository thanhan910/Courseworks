package com.example.taskapp.data.data

import android.os.Parcelable
import androidx.room.*
import kotlinx.parcelize.Parcelize
import java.util.*

const val TASK_TABLE =  "task_table"
const val COL_id = "id"
const val COL_name = "name"
const val COL_status = "status"
const val COL_starred = "starred"
const val COL_due = "due"
const val COL_estimate = "estimate"
const val COL_plan = "plan"
const val COL_remind = "remind"
const val COL_description = "description"
const val COL_createdTime = "createdTime"
const val COL_checkedTime = "checkedTime"
const val COL_modifiedTime = "modifiedTime"

@Parcelize
@Entity(tableName = TASK_TABLE)
data class Task(
    @PrimaryKey(autoGenerate = true) val id: Long,
    @ColumnInfo(name = "name") var name: String,
    @ColumnInfo(name = "status") var status: Int,
    @ColumnInfo(name = "starred") var starred: Boolean,
    @ColumnInfo(name = "due") var due: Date?,
    @ColumnInfo(name = "estimate") var estimate: Int?,
    @ColumnInfo(name = "plan") var plan: Date?,
    @ColumnInfo(name = "remind") var remind: Date?,
    @ColumnInfo(name = "description") var description: String?,
    @ColumnInfo(name = "createdTime") var createdTime: Date?,
    @ColumnInfo(name = "checkedTime") var checkedTime: Date?,
    @ColumnInfo(name = "modifiedTime") var modifiedTime: Date?,
    ) : Parcelable {
    constructor(name: String, status: Int, starred: Boolean, due: Date?, estimate: Int?, plan: Date?, remind: Date?, description: String?) :
            this(0, name, status, starred, due, estimate, plan, remind, description, Calendar.getInstance().time, null, Calendar.getInstance().time)
    constructor(name: String, status: Int, starred: Boolean, due: Date?) :
            this(name, status, starred, due, null, null, null, null)
    constructor() :
            this("", 0, false, null)

    override fun equals(other: Any?) = other is Task
            && other.id == id
            && stringEquals(other.name, name)
            && other.status == status
            && other.starred == starred
            && other.estimate == estimate
            && other.due == due
            && other.plan == plan
            && other.remind == remind
            && stringEquals(other.description, description)

    private fun stringEquals(lString: String?, rString: String?): Boolean {
        val l = lString?.trim { it <= ' ' } ?: ""
        val r = rString?.trim { it <= ' ' } ?: ""
        return l == r
    }

    override fun hashCode(): Int {
        var result = id.hashCode()
        result = 31 * result + name.hashCode()
        result = 31 * result + status
        result = 31 * result + starred.hashCode()
        result = 31 * result + (due?.hashCode() ?: 0)
        result = 31 * result + (estimate ?: 0)
        result = 31 * result + (plan?.hashCode() ?: 0)
        result = 31 * result + (remind?.hashCode() ?: 0)
        result = 31 * result + (description?.hashCode() ?: 0)
        result = 31 * result + (createdTime?.hashCode() ?: 0)
        result = 31 * result + (checkedTime?.hashCode() ?: 0)
        result = 31 * result + (modifiedTime?.hashCode() ?: 0)
        return result
    }
}
