package com.example.taskapp.ui.main

import androidx.lifecycle.*
import com.example.taskapp.data.data.TASK_TABLE
import com.example.taskapp.data.data.Task
import com.example.taskapp.data.data.COL_status
import com.example.taskapp.data.repository.MyRepository
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch

/**
 * View Model to keep a reference to the word repository and
 * an up-to-date list of all items.
 */

/**
 * Using LiveData and caching what allItems returns has several benefits:
 * - We can put an observer on the data (instead of polling for changes) and only update
 * the UI when the data actually changes.
 * - Repository is completely separated from the UI through the ViewModel.
 */

/**
 * Launching a new coroutine to insert the data in a non-blocking way
 */

class MainViewModel (private val repository: MyRepository) : ViewModel() {

    private var mainQuery: String = "SELECT * FROM $TASK_TABLE WHERE $COL_status = 0"
    private var mutableQuery = MutableLiveData(mainQuery)

//    Credits: https://stackoverflow.com/questions/47515997/observing-livedata-from-viewmodel
    val tasks: LiveData<List<Task>> = Transformations.switchMap(mutableQuery) { q ->
        return@switchMap repository.getTasksViaQuery(q).asLiveData()
    }

    private val whereMap: MutableMap<String, String> = mutableMapOf()

    fun setWhere(column: String, value: String)  : MainViewModel {
        whereMap[column] = value
        return this
    }
    fun removeWhere(column: String) : MainViewModel {
        whereMap.remove(column)
        return this
    }
    fun clearWhere() : MainViewModel {
        whereMap.clear()
        return this
    }

    private val orderMap: MutableMap<String, String> = mutableMapOf()
    fun setOrder(column: String, value: String) : MainViewModel {
        orderMap[column] = value
        return this
    }
    fun removeOrder(column: String) : MainViewModel {
        orderMap.remove(column)
        return this
    }
    fun clearOrder() : MainViewModel {
        orderMap.clear()
        return this
    }

    fun makeQuery() {
        mainQuery = "SELECT * FROM $TASK_TABLE"
        if(whereMap.isNotEmpty()) {
            var isFirst = true
            for((col, value) in whereMap) {
                if(value.isEmpty()) continue
                mainQuery += if(isFirst) {
                    " WHERE"
                } else {
                    " AND"
                }
                mainQuery += " $col $value"
                isFirst = false
            }
        }
        if(orderMap.isNotEmpty()) {
            var isFirst = true
            for((col, value) in orderMap) {
                if(value.isEmpty()) continue
                mainQuery += if(isFirst) {
                    " ORDER BY"
                } else {
                    ","
                }
                // the sqlite version of this app does not support NULLS LAST yet
                mainQuery += if(value.contains("ASC NULLS LAST")) " CASE WHEN $col IS NULL THEN 1 ELSE 0 END, $col ASC"
                else " $col $value"
                isFirst = false
            }
        }
        mutableQuery.postValue(mainQuery)
    }

    fun update(item: Task) {

        viewModelScope.launch(Dispatchers.IO) {
            repository.update(item)
        }
    }
}

class MainViewModelFactory(private val repository: MyRepository) : ViewModelProvider.Factory {
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        if (modelClass.isAssignableFrom(MainViewModel::class.java)) {
            @Suppress("UNCHECKED_CAST")
            return MainViewModel(repository) as T
        }
        throw IllegalArgumentException("Unknown ViewModel class")
    }
}

