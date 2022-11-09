package com.example.taskapp.data.repository

import androidx.annotation.WorkerThread
import androidx.sqlite.db.SimpleSQLiteQuery
import com.example.taskapp.data.data.Task
import com.example.taskapp.data.data.MyDao
import com.example.taskapp.data.data.TASK_TABLE
import io.reactivex.Single
import kotlinx.coroutines.flow.Flow
import java.util.concurrent.Callable

/**
 * Abstracted Repository as promoted by the Architecture Guide.
 * https://developer.android.com/topic/libraries/architecture/guide.html
 */
class MyRepository(private val myDao: MyDao) {

    // Room executes all queries on a separate thread.
    // Observed Flow will notify the observer when the data has changed.

    // By default Room runs suspend queries off the main thread, therefore, we don't need to
    // implement anything else to ensure we're not doing long running database work
    // off the main thread.
    @Suppress("RedundantSuspendModifier")


    @WorkerThread
    suspend fun insert(task: Task) {
        return myDao.insert(task)
    }

    @WorkerThread
    suspend fun update(task: Task) {
        myDao.update(task)
    }
    @WorkerThread
    suspend fun delete(task: Task) {
        myDao.delete(task)
    }

    @WorkerThread
    suspend fun deleteAllTasks() {
        return myDao.deleteAllTasks()
    }

    @WorkerThread
    fun getAllTasks(): Flow<List<Task>> {
        return myDao.getAllTasks()
    }

    @WorkerThread
    fun getTasksViaQuery(query: String): Flow<List<Task>> {
        return myDao.getTasksViaQuery(SimpleSQLiteQuery(query))
    }

    companion object {

        // For Singleton instantiation
        @Volatile private var instance: MyRepository? = null

        fun getInstance(myDao: MyDao) =
            instance ?: synchronized(this) {
                instance ?: MyRepository(myDao).also { instance = it }
            }
    }

}