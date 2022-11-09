package com.example.taskapp.data.data

import androidx.room.*
import androidx.sqlite.db.SimpleSQLiteQuery
import androidx.sqlite.db.SupportSQLiteQuery
import kotlinx.coroutines.flow.Flow


/**
 * The Room Magic is in this file, where you map a method call to an SQL query.
 *
 * When you are using complex data types, such as Date, you have to also supply type converters.
 * See the documentation at
 * https://developer.android.com/topic/libraries/architecture/room.html#type-converters
 */

@Dao
interface MyDao {

    @Transaction
    @Query("SELECT * FROM $TASK_TABLE")
    fun getAllTasks(): Flow<List<Task>>

    @Transaction
    @Query("SELECT * FROM $TASK_TABLE WHERE id = :id")
    fun getTaskById(id: Long): Task

    @Insert(onConflict = OnConflictStrategy.IGNORE)
    suspend fun insert(task: Task)

    @Update(onConflict = OnConflictStrategy.IGNORE)
    suspend fun update(task: Task)

    @Delete
    suspend fun delete(task: Task)

    @Query("DELETE FROM $TASK_TABLE")
    suspend fun deleteAllTasks()

    @Transaction
    @RawQuery(observedEntities = [Task::class])
    fun getTasksViaQuery(query: SupportSQLiteQuery): Flow<List<Task>>

    //    // TODO: Add reminders with task id
//    // When inserting a new item, return its id to start reminders
//    @Insert(onConflict = OnConflictStrategy.IGNORE)
//    suspend fun insert(task: Task): Long
}