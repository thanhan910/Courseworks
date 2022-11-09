package com.example.taskapp.application

import android.app.*
import com.example.taskapp.data.data.MyDatabase
import com.example.taskapp.data.repository.MyRepository
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.SupervisorJob

// Credits: Florina Muntenescu, https://developer.android.com/codelabs/android-room-with-a-view-kotlin#0

class MyApplication : Application() {
    // No need to cancel this scope as it'll be torn down with the process
    private val applicationScope = CoroutineScope(SupervisorJob())

    // Using by lazy so the database and the repository are only created when they're needed
    // rather than when the application starts
    private val database by lazy { MyDatabase.getDatabase(this, applicationScope) }
    val repository by lazy { MyRepository.getInstance(database.myDao()) }

}