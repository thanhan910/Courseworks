package com.example.taskapp.ui.main

import android.os.Bundle
import android.view.*
import androidx.activity.viewModels
import androidx.appcompat.app.ActionBarDrawerToggle
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.GravityCompat
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.taskapp.application.MyApplication
import com.example.taskapp.R
import com.example.taskapp.databinding.ActivityMainBinding
import com.example.taskapp.data.data.*
import com.example.taskapp.ui.add.AddFragment

private const val SELECTED_NAV = "selected_nav"
private const val SELECTED_SORT = "selected_sort"

class MainActivity : AppCompatActivity() {

    private lateinit var binding: ActivityMainBinding
    private lateinit var toggle: ActionBarDrawerToggle

    private val viewModel: MainViewModel by viewModels {
        MainViewModelFactory((application as MyApplication).repository)
    }

    // Save to Bundle selected sorting option and navigated location
    private var selectedNav = R.id.nav_home
    private var selectedSort = R.id.action_clear_order

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        if (savedInstanceState != null) {
            selectedNav = savedInstanceState.getInt(SELECTED_NAV)
            selectedSort = savedInstanceState.getInt(SELECTED_SORT)
        }

        binding = ActivityMainBinding.inflate(layoutInflater)
        setContentView(binding.root)

        val drawerLayout = binding.drawerLayout

        // setup the navigation drawer
        val navView = binding.navView
        navView.setNavigationItemSelectedListener {
            selectedNav = it.itemId
            drawerLayout.closeDrawer(GravityCompat.START)
            onNavItemSelected(it)
            true
        }
        navView.setCheckedItem(selectedNav) // resume the saved navigation mode
        onNavItemSelected(navView.menu.findItem(selectedNav)) // resume the saved navigation mode
        onSortOptionSelected(selectedSort) // resume the saved sorting option mode

        setSupportActionBar(binding.appBarMain.toolbar) // setup the heading support action bar. This must be put after toolbar title has been set

        // setup the toggle top left corner button of navigation drawer
        toggle =
            ActionBarDrawerToggle(this@MainActivity, drawerLayout, R.string.open, R.string.close)
        drawerLayout.addDrawerListener(toggle)
        toggle.syncState()
        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        // create adapter
        val adapter = MainAdapter { viewModel.update(it) }
        adapter.setHasStableIds(true) // bind id of data to id of row view

        val recyclerView = findViewById<RecyclerView>(R.id.recyclerViewNumberList)
        recyclerView.adapter = adapter
        recyclerView.layoutManager = LinearLayoutManager(this)
        registerForContextMenu(recyclerView) // context menu is registered for the check icon of each row

        // adapter subscribe to livedata and observe the changes of the data
        viewModel.tasks.observe(this) { tasks ->
            adapter.submitList(tasks) // repopulates the items in recycler view
        }

        binding.appBarMain.fab.setOnClickListener {
            AddFragment.newInstance().show(supportFragmentManager, "dialog")
        }
    }

    private fun onNavItemSelected(it: MenuItem) {
        binding.appBarMain.toolbar.title = it.title // change the title of activity
        // reset the query that viewModel is using to get the data from the database
        when (it.itemId) {
            R.id.nav_home -> viewModel.clearWhere().clearOrder().setWhere(
                COL_status, "= 0"
            ).makeQuery()
            R.id.nav_all -> viewModel.clearWhere().clearOrder().makeQuery()
            R.id.nav_starred -> viewModel.clearWhere().clearOrder().setWhere(COL_starred, "= 1")
                .makeQuery()
            R.id.nav_upcoming -> viewModel.clearWhere().clearOrder()
                .setWhere(COL_due, "IS NOT NULL").setOrder(COL_due, "ASC NULLS LAST").makeQuery()
            R.id.nav_planned -> viewModel.clearWhere().clearOrder()
                .setWhere(COL_plan, "IS NOT NULL").setOrder(COL_plan, "ASC NULLS LAST").makeQuery()
            R.id.nav_completed -> viewModel.clearWhere().clearOrder().setWhere(
                COL_status, "= 1"
            ).makeQuery()
            R.id.nav_wont_do -> viewModel.clearWhere().clearOrder().setWhere(
                COL_status, "= 2"
            ).makeQuery()
            else -> viewModel.clearWhere().clearOrder().setWhere(
                COL_status, "= 0"
            ).makeQuery()
        }
    }

    private fun onSortOptionSelected(itemId: Int): Boolean {
        // reset the order query that viewModel is using to get the data from the database
        when (itemId) {
            R.id.action_sort_due_asc -> {
                viewModel.clearOrder().setOrder(COL_due, "ASC NULLS LAST").makeQuery()
                return true
            }
            R.id.action_sort_due_desc -> {
                viewModel.clearOrder().setOrder(COL_due, "DESC").makeQuery()
                return true
            }
            R.id.action_sort_estimate_asc -> {
                viewModel.clearOrder().setOrder(COL_estimate, "ASC NULLS LAST").makeQuery()
                return true
            }
            R.id.action_sort_estimate_desc -> {
                viewModel.clearOrder().setOrder(COL_estimate, "DESC").makeQuery()
                return true
            }
            R.id.action_sort_plan_asc -> {
                viewModel.clearOrder().setOrder(COL_plan, "ASC NULLS LAST").makeQuery()
                return true
            }
            R.id.action_sort_plan_desc -> {
                viewModel.clearOrder().setOrder(COL_plan, "DESC").makeQuery()
                return true
            }
            R.id.action_sort_created_time_asc -> {
                viewModel.clearOrder().setOrder(COL_createdTime, "ASC NULLS LAST").makeQuery()
                return true
            }
            R.id.action_sort_created_time_desc -> {
                viewModel.clearOrder().setOrder(COL_createdTime, "DESC").makeQuery()
                return true
            }
            R.id.action_sort_modified_time_asc -> {
                viewModel.clearOrder().setOrder(COL_modifiedTime, "ASC NULLS LAST").makeQuery()
                return true
            }
            R.id.action_sort_modified_time_desc -> {
                viewModel.clearOrder().setOrder(COL_modifiedTime, "DESC").makeQuery()
                return true
            }
            R.id.action_sort_checked_time_asc -> {
                viewModel.clearOrder().setOrder(COL_checkedTime, "ASC NULLS LAST").makeQuery()
                return true
            }
            R.id.action_sort_checked_time_desc -> {
                viewModel.clearOrder().setOrder(COL_checkedTime, "DESC").makeQuery()
                return true
            }
            R.id.action_clear_order -> {
                viewModel.clearOrder().makeQuery()
                return true
            }
            else -> return false
        }
    }

    override fun onSaveInstanceState(outState: Bundle) {
        super.onSaveInstanceState(outState)
        outState.putInt(SELECTED_NAV, selectedNav)
        outState.putInt(SELECTED_SORT, selectedSort)
    }

    override fun onOptionsItemSelected(item: MenuItem): Boolean {
        return if (toggle.onOptionsItemSelected(item)) {
            true
        } else {
            selectedSort = item.itemId
            val sortOptionSelected = onSortOptionSelected(item.itemId)
            if (sortOptionSelected) true
            else super.onOptionsItemSelected(item)
        }
    }

    override fun onCreateOptionsMenu(menu: Menu): Boolean {
        // Inflate the menu; this adds items to the action bar if it is present.
        menuInflater.inflate(R.menu.sort_options_menu, menu)
        return true
    }
}