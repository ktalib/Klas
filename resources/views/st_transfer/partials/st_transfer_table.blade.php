 <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      <input type="checkbox" class="rounded" onchange="toggleSelectAll(this)">
                    </th>
                     
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      FileNo
                    </th>
                    
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                     Number Of Units
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                     Number Of Blocks
                    </th> 
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Number Of Sections
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Owner
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Property Description
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg.No
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg. Time
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg. Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Reg.By
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                      Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500  tracking-wider">
                      Actions
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="cofoTableBody">
                  @foreach($approvedApplications as $app)
                  <tr class="cofo-row" data-status="{{ $app->status }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <input type="checkbox" class="rounded">
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{ $app->fileno }}</td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->NoOfUnits }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->NoOfBlocks ?: 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->NoOfSections ?: 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->owner_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->property_description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ !empty($app->Deeds_Serial_No) ? $app->Deeds_Serial_No : 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ !empty($app->deeds_time) ? $app->deeds_time : 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $app->deeds_date ? date('Y-m-d', strtotime($app->deeds_date)) : 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      @if($app->status === 'pending')
                        N/A
                      @else
                        {{ !empty($app->reg_creator_name) ? $app->reg_creator_name : 'System' }}
                      @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      <span class="badge badge-{{ $app->status }}">{{ ucfirst($app->status) }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm relative" x-data="{ 
                      open: false,
                      updatePosition() {
                        if (this.open) {
                          const button = this.$refs.actionButton;
                          const menu = this.$refs.actionMenu;
                          const rect = button.getBoundingClientRect();
                          menu.style.top = `${rect.bottom + 5}px`;
                          menu.style.left = `${rect.right - menu.offsetWidth}px`;
                        }
                      },
                      toggle() {
                        this.open = !this.open;
                        if (this.open) {
                          this.$nextTick(() => {
                            this.updatePosition();
                            // Add scroll event listener when menu is opened
                            window.addEventListener('scroll', () => this.updatePosition(), { passive: true });
                          });
                        } else {
                          // Remove scroll event listener when menu is closed
                          window.removeEventListener('scroll', () => this.updatePosition());
                        }
                      },
                      // Ensure we clean up event listeners when component is destroyed
                      init() {
                        this.$watch('open', value => {
                          if (!value) {
                            window.removeEventListener('scroll', () => this.updatePosition());
                          }
                        });
                      }
                    }">
                      <button 
                        x-ref="actionButton"
                        @click="toggle()" 
                        class="text-gray-500 hover:text-gray-700">
                        <i data-lucide="more-vertical"></i>
                      </button>
                    
                      @include('st_transfer.partials.action')
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>