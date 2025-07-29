import { useEffect, useState } from 'react';
import DataTable, { TableStyles } from 'react-data-table-component';
import { Input } from './ui/input';

const customStyles: TableStyles = {
    table: {
        style: {
            backgroundColor: '#1e293b',
            color: '#f8fafc',
        },
    },
    header: {
        style: {
            backgroundColor: '#1e293b',
            color: '#f8fafc',
        },
    },
    headRow: {
        style: {
            backgroundColor: '#1e293b',
            color: '#f8fafc',
            borderBottomColor: '#334155',
        },
    },
    headCells: {
        style: {
            color: '#f8fafc',
        },
    },
    rows: {
        style: {
            backgroundColor: '#1e293b',
            color: '#f8fafc',
            '&:not(:last-of-type)': {
                borderBottomColor: '#334155',
            },
        },
    },
    pagination: {
        style: {
            backgroundColor: '#1e293b',
            color: '#f8fafc',
        },
    },
};

// eslint-disable-next-line @typescript-eslint/no-explicit-any
export default function DataTables({ columns, data, searchBy }: { columns: any[]; data: any[]; searchBy: string[] }) {
    const [filteredData, setFilteredData] = useState(data);
    const [searchTerm, setSearchTerm] = useState('');

    useEffect(() => {
        if (searchTerm) {
            const filtered = data.filter((row) =>
                searchBy.some((key) => {
                    const cellValue = row[key]?.toString().toLowerCase() || '';
                    return cellValue.includes(searchTerm.toLowerCase());
                }),
            );
            setFilteredData(filtered);
        } else {
            setFilteredData(data);
        }
    }, [data, searchTerm, searchBy]);

    const handleSearch = (event: React.ChangeEvent<HTMLInputElement>) => {
        const search = event.target.value;
        setSearchTerm(search);

        if (search) {
            const filtered = data.filter((row) =>
                searchBy.some((key) => {
                    const cellValue = row[key]?.toString().toLowerCase() || '';
                    return cellValue.includes(search.toLowerCase());
                }),
            );
            setFilteredData(filtered);
        } else {
            setFilteredData(data);
        }
    };

    return (
        <div className="rounded-md bg-slate-800 p-4 text-slate-100">
            <div className="flex w-full justify-end">
                <div className="mb-4 w-44">
                    <Input
                        className="bg-slate-700 text-white placeholder:text-slate-400"
                        placeholder="Cari data..."
                        value={searchTerm}
                        onChange={handleSearch}
                    />
                </div>
            </div>
            <DataTable columns={columns} data={filteredData} pagination paginationPerPage={10} customStyles={customStyles} />
        </div>
    );
}
