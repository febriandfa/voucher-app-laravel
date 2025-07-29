export default function DataCard({ category, number, icon }: { category: string; number: number; icon: React.ReactNode }) {
    return (
        <div className="rounded-lg border p-4">
            <h2 className="text-lg font-semibold text-white">{category}</h2>
            <p className="flex items-center gap-2 text-2xl text-white">
                {icon}
                {number}
            </p>
        </div>
    );
}
